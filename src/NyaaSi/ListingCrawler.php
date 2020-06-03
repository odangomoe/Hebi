<?php


namespace Odango\Hebi\NyaaSi;


use DOMWrap\Document;
use DOMWrap\Element;
use Odango\Hebi\Model\Torrent;
use Odango\Hebi\Model\TorrentQuery;

use function GuzzleHttp\Psr7\parse_query;

class ListingCrawler
{
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function run($directory)
    {
        $items = glob("$directory/*.html");
        foreach ($items as $item) {
            $this->readListing($item);
        }
    }

    public function readListing($file)
    {
        $data = file_get_contents($file);
        $doc  = new Document();
        $doc->setHtml($data);

        $torrentItems    = $doc->find('.torrent-list > tbody > tr');
        $foundTorrents   = [];
        $foundTorrentIds = [];

        /** @var Element $torrentItem */
        foreach ($torrentItems as $torrentItem) {
            /** @var Element[] $columns */
            $columns  = $torrentItem->children();
            $category = substr($columns[0]->find('a')->first()->getAttribute('href'), 4);

            if ($category !== '1_2') {
                continue;
            }

            /** @var Element $link */
            $link            = $columns[1]->find('a')->first();
            $parts           = explode('/', $link->getAttribute('href'));
            $torrentId       = intval(array_pop($parts));
            $torrentTitle    = $link->getAttribute('title');
            $magnet          = $columns[2]->find('a')->last();
            $magnetUri       = $magnet->getAttribute('href');
            $query           = parse_query(substr($magnetUri, 8));
            $torrentTrackers = (array)($query['tr'] ?? []);
            $xtParts         = explode(":", $query['xt']);
            $torrentInfoHash = array_pop($xtParts);

            $foundTorrents[$torrentId] = [$torrentId, $torrentTitle, $torrentInfoHash, $torrentTrackers];
            $foundTorrentIds[]         = $torrentId;
        }

        $items = TorrentQuery::create()->findById($foundTorrentIds);
        foreach ($items as $item) {
            echo "Skipping Torrent#" . $item->getId() . " already known\n";
            unset($foundTorrents[$item->getId()]);
        }

        foreach ($foundTorrents as $foundTorrent) {
            $torrent = new Torrent();
            $torrent->setId($foundTorrent[0]);
            $torrent->setTorrentTitle($foundTorrent[1]);
            $torrent->setInfoHash($foundTorrent[2]);
            $torrent->setTrackers($foundTorrent[3]);
            $torrent->setDateCrawled(new \DateTime());
            $torrent->setSubmitterId(0);

            $torrent->save();
            $torrent->createMetadata();

            echo "Added Torrent#" . $torrent->getId() . "\n";
        }
    }
}