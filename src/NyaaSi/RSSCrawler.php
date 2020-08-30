<?php


namespace Odango\Hebi\NyaaSi;


use DOMWrap\Document;
use GuzzleHttp\Client;
use Odango\Hebi\Model\Torrent;
use Odango\Hebi\Model\TorrentQuery;
use Propel\Runtime\ActiveQuery\Criteria;

use SimpleXMLElement;

use function GuzzleHttp\Psr7\parse_query;


class RSSCrawler
{
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function run($version = "")
    {

        /** @var Client $client */
        $client = $this->container['guzzle'];

        if ($version === "") {
            $data = $client->get('https://nyaa.si/?page=rss&c=1_2&m');
            $latestKnown = TorrentQuery::create()->orderById(Criteria::DESC)->findOne();
        }
        if ($version === "sukebei") {
            $data = $client->get('https://sukebei.nyaa.si/?page=rss&c=1_1&m');
            $latestKnown = TorrentQuery::create()->orderById(Criteria::ASC)->findOne();
        }

        $latestKnownId = 0;

        if (!isset($data) || !$data) {
            throw new \Exception("Failed to fetch data");
        }

        if ($latestKnown !== null) {
            $latestKnownId = intval($latestKnown->getId());
        }

        $doc = new SimpleXMLElement($data->getBody()->getContents());
        $foundLatest = false;

        foreach ($doc->channel->item as $item) {
            $currentInfoHash = $item->xpath('nyaa:infoHash')[0]->__toString();

            $link = explode("/", trim($item->guid->__toString()));
            $currentId = intval($link[count($link) - 1]);

            $currentTitle = $item->title->__toString();
            $magnetUri = trim($item->link->__toString());
            $query = parse_query(substr($magnetUri, 8));
            $currentTrackers = (array)($query['tr'] ?? []);

            if ($currentInfoHash === null || $currentTitle === null || $currentTrackers === null || $currentId === null) {
                error_log("Found invalid item in RSS?");
                continue;
            }

            if ($version === "sukebei") {
                $currentId = -$currentId;
            }

            if (($version === "" && $latestKnownId > $currentId) || ($version === "sukebei" && $latestKnownId < $currentId )) {
                continue;
            }

            if ($latestKnownId === $currentId) {
                $foundLatest = true;
                continue;
            }

            $torrent = new Torrent();
            $torrent->setId($currentId);
            $torrent->setTorrentTitle($currentTitle);
            $torrent->setInfoHash($currentInfoHash);
            $torrent->setDateCrawled(new \DateTime());
            # nyaa.si hides the submitter_id and only shows
            # names
            $torrent->setSubmitterId(0);
            $torrent->setTrackers($currentTrackers);

            $torrent->save();
            $torrent->createMetadata();

            echo 'Saved torrent#' . $currentId . ' => ' . $torrent->getTorrentTitle() . "\n";
        }

        if (!$foundLatest && $latestKnownId !== 0) {
            echo "Didn't find latest torrent ($latestKnownId), you might want to setup a higher poll-rate";
        }
    }
}