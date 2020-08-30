<?php


namespace Odango\Hebi\NyaaSi;


use DOMWrap\Document;
use DOMWrap\Element;
use Odango\Hebi\Model\Torrent;
use Odango\Hebi\Model\TorrentQuery;
use Propel\Runtime\Propel;

use function GuzzleHttp\Psr7\parse_query;

class PageCrawler
{
    private $container;
    /**
     * @var array
     */
    private $foundTorrentIds = [];
    private $foundTorrents = [];

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function run($directory)
    {
        $items = glob("$directory/*.html");
        foreach ($items as $item) {
            $this->readPage($item);

            if (count($this->foundTorrentIds) > 100) {
                $this->commit();
            }
        }

        $this->commit();
    }

    public function readPage($file)
    {
        $data = file_get_contents($file);
        $doc  = new Document();
        $doc->setHtml($data);

        $brand = $doc->find('.navbar-brand')->text();

        foreach ($doc->find('.panel-body .row') as $row) {
            if (substr(trim($row->text()),0, 8) !== 'Category'){
                continue;
            }

            $query = parse_url($row->find('a')->last()->getAttribute('href'), PHP_URL_QUERY);
            $query = parse_query($query);
            $category = $query['c'];
            break;
        }


        if (($brand !== "Sukebei" && $category !== '1_2') || ($brand === "Sukebei" && $category !== "1_1")) {
            return;
        }

        /** @var Element $link */
        $link            = $doc->find('.panel-footer .fa-download')->parent()->first();
        if ($link !== null) {
            $parts = explode('/', $link->getAttribute('href'));
        } else {
            $parts = explode('/', substr($file, 0, -5));
        }
        $torrentId       = intval(array_pop($parts));
        if ($torrentId === 0 || $torrentId === false) {
            return;
        }
        $torrentTitle    = trim($doc->find('.panel-heading > h3.panel-title')->first()->text());
        $magnet          = $doc->find('.panel-footer a > .fa-magnet')->parent()->first();
        $magnetUri       = $magnet->getAttribute('href');
        $query           = parse_query(substr($magnetUri, 8));
        $torrentTrackers = (array)($query['tr'] ?? []);
        $xtParts         = explode(":", $query['xt']);
        $torrentInfoHash = array_pop($xtParts);

        if ($brand === "Sukebei") {
            $torrentId = -$torrentId;
        }

        $this->foundTorrents[$torrentId] = [$torrentId, $torrentTitle, $torrentInfoHash, $torrentTrackers];
        $this->foundTorrentIds[]         = $torrentId;
    }

    public function commit() {
        $conn = Propel::getWriteConnection('default');

        $conn->beginTransaction();

        $items = TorrentQuery::create()->findById($this->foundTorrentIds);
        foreach ($items as $item) {
            list($id, $title) = $this->foundTorrents[$item->getId()];
            if ($item->getTorrentTitle() !== $title) {
                $item->setTorrentTitle($title);

                $item->save($conn);
                $item->createMetadata($conn);

                echo "Updated Torrent#" . $item->getId() . "\n";
            } else {
                echo "Skipped Torrent#" . $item->getId() . "\n";
            }

            unset($this->foundTorrents[$item->getId()]);
        }

        foreach ($this->foundTorrents as $foundTorrent) {
            $torrent = new Torrent();
            $torrent->setId($foundTorrent[0]);
            $torrent->setTorrentTitle($foundTorrent[1]);
            $torrent->setInfoHash($foundTorrent[2]);
            $torrent->setTrackers($foundTorrent[3]);
            $torrent->setDateCrawled(new \DateTime());
            $torrent->setSubmitterId(0);

            $torrent->save($conn);
            $torrent->createMetadata($conn);

            echo "Added Torrent#".$torrent->getId()." [" . $foundTorrent[1] .  "]\n";
        }
        $conn->commit();

        $this->foundTorrentIds = [];
        $this->foundTorrents = [];
    }
}