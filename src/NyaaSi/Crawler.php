<?php


namespace Odango\Hebi\NyaaSi;


use GuzzleHttp\Client;
use function GuzzleHttp\Psr7\parse_query;
use Odango\Hebi\Model\Torrent;
use Odango\Hebi\Model\TorrentQuery;
use Propel\Runtime\ActiveQuery\Criteria;

class Crawler
{
    private $container;

    public function __construct($container)
    {
        $this->container = $container;

    }

    public function run() {
        $latestId = $this->getLatestId();

        echo 'Latest id: ' . $latestId . "\n";

        $latestKnown = TorrentQuery::create()->orderById(Criteria::DESC)->findOne();
        $latestKnownId = 0;

        if ($latestKnown !== null) {
            $latestKnownId = $latestKnown->getId();
        }

        echo 'Latest known id: ' . $latestKnownId . "\n";
        echo 'Amount of links to crawl: ' . ($latestId - $latestKnownId) . "\n";

        $this->crawl($latestKnownId, $latestId);
    }

    public function crawl($from, $to) {
        for ($i = ($from + 1); $i <= $to; $i++) {
            // TODO: track status of crawling, so errors get retried
            try {
                $this->crawlTorrent($i);
            } catch (\Exception $e) {
                echo 'Failed crawling torrent#' . $i . ' => ' . $e->getMessage();
            }
            // 24 hours, is 86400 pages.
            sleep(1);
        }
    }

    public function crawlTorrent($id) {
        /** @var Client $client */
        $client = $this->container['guzzle'];

        $info = \GuzzleHttp\json_decode($client->request('GET', 'https://nyaa.si/api/info/' . $id, [
            'auth' => $this->container['config']['nyaa.si']['auth']
        ])->getBody()->getContents(), true);

        if ($info['main_category_id'] !== 1 || $info['sub_category_id'] !== 2) {
            echo 'Skipping torrent#' . $id . " (wrong category)\n";
            return;
        }

        $torrent = new Torrent();
        $torrent->setId($id);
        $torrent->setTorrentTitle($info['name']);
        $torrent->setInfoHash($info['hash_hex']);
        $torrent->setDateCrawled(new \DateTime());
        # nyaa.si hides the submitter_id and only shows
        # names
        $torrent->setSubmitterId(0);
        $query = parse_query(substr($info['magnet'], 8));
        $torrent->setTrackers((array)($query['tr'] ?? []));

        $torrent->save();
        $torrent->createMetadata();

        echo 'Saved torrent#' . $id . ' => ' . $torrent->getTorrentTitle() . "\n";
    }

    public function getLatestId() {
        /** @var Client $client */
        $client = $this->container['guzzle'];

        $html = $client->request('GET', 'https://nyaa.si')->getBody()->getContents();

        preg_match_all('~\/view\/([0-9]+)~', $html, $matches);

        return max($matches[1]);
    }
}