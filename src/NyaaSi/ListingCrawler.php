<?php


namespace Odango\Hebi\NyaaSi;


use DOMWrap\Document;
use DOMWrap\Element;
use Odango\Hebi\Model\Torrent;
use Odango\Hebi\Model\TorrentQuery;
use Propel\Runtime\Propel;

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

        $brand = $doc->find('.navbar-brand')->text();

        $torrentItems    = $doc->find('.torrent-list > tbody > tr');
        $foundTorrents   = [];
        $foundTorrentIds = [];

        /** @var Element $torrentItem */
        foreach ($torrentItems as $torrentItem) {
            /** @var Element[] $columns */
            $columns  = $torrentItem->children();
            $query = parse_url($columns[0]->find('a')->first()->getAttribute('href'), PHP_URL_QUERY);
            $query = parse_query($query);
            $category = $query['c'];

            if (($brand !== "Sukebei" && $category !== '1_2') || ($brand === "Sukebei" && $category !== "1_1")) {
                continue;
            }

            /** @var Element $link */
            $link            = $columns[1]->find('a')->last();
            $parts           = explode('/', $link->getAttribute('href'));
            $torrentId       = intval(array_pop($parts));
            $torrentTitle    = $link->getAttribute('title');
            $magnet          = $columns[2]->find('a')->last();
            $magnetUri       = $magnet->getAttribute('href');
            $query           = parse_query(substr($magnetUri, 8));
            $torrentTrackers = (array)($query['tr'] ?? []);
            $xtParts         = explode(":", $query['xt']);
            $torrentInfoHash = array_pop($xtParts);

            if ($brand === "Sukebei") {
                $torrentId = -$torrentId;
            }

            $foundTorrents[$torrentId] = [$torrentId, $torrentTitle, $torrentInfoHash, $torrentTrackers];
            $foundTorrentIds[]         = $torrentId;
        }

        $conn = Propel::getWriteConnection('default');

        $conn->beginTransaction();

        $items = TorrentQuery::create()->findById($foundTorrentIds);
        foreach ($items as $item) {
            list($id, $title) = $foundTorrents[$item->getId()];
            if ($item->getTorrentTitle() !== $title) {
                $item->setTorrentTitle($title);

                $item->save($conn);
                $item->createMetadata($conn);

                echo "Updated Torrent#" . $item->getId() . "\n";
            } else {
                echo "Skipped Torrent#" . $item->getId() . "\n";
            }

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

            $torrent->save($conn);
            $torrent->createMetadata($conn);

            echo "Added Torrent#".$torrent->getId()."\n";
        }
        $conn->commit();
    }
}