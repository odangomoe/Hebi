<?php


namespace Odango\Hebi\Test\Nyaa;


use Odango\Hebi\Main;
use Odango\Hebi\Model\Torrent;
use Odango\Hebi\Model\TorrentMetadata;
use Odango\Hebi\Model\TorrentMetadataQuery;
use Odango\Hebi\Model\TorrentQuery;
use Odango\Hebi\Nyaa\Iterator;
use Propel\Runtime\Propel;


class IteratorTest extends \PHPUnit_Framework_TestCase
{
    private $container;

    public function setUp()
    {
        $main = new Main();
        $main->init("test");
        $this->container = $main->getContainer();
        $this->container['config'] = [
            'nyaa' => [
                'category' => [
                    '1_37'
                ],
                'page-path' => __DIR__ . "/../data/pages/%d.html",
                'torrent-path' => __DIR__ . "/../data/torrents/%d.torrent",
                'status-file' => __DIR__ . "/../data/example-status.json",
            ]
        ];

        $torrent = new Torrent();
        $torrent->setId(15);
        $torrent->setSubmitterId(64513);
        $torrent->setInfoHash("henk");
        $torrent->setTorrentTitle("[HorribleSubs] Kabaneri of the Iron Fortress - 12 [1080p].mkv");
        $torrent->createMetadata();
        $torrent->save();
    }

    public function testIteration() {
        $iterator = new Iterator($this->container);
        $iterator->start();

        $torrents = TorrentQuery::create()->find();
        $torrentMetadata = TorrentMetadataQuery::create()->find();

        $this->assertCount(3, $torrents);
        $this->assertCount(3, $torrentMetadata);
    }

    public function tearDown()
    {
        TorrentMetadataQuery::create()->deleteAll();
        TorrentQuery::create()->deleteAll();
    }
}
