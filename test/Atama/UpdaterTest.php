<?php


namespace Odango\Hebi\Test\Atama;


use Odango\Hebi\Atama\Updater;
use Odango\Hebi\Main;
use Odango\Hebi\Model\Torrent;
use Odango\Hebi\Model\TorrentMetadataQuery;
use Odango\Hebi\Model\TorrentQuery;


class UpdaterTest extends \PHPUnit_Framework_TestCase
{
    private $container;

    public function setUp()
    {
        $main = new Main();
        $main->init('test');
        $this->container = $main->getContainer();
        $torrent = new Torrent();
        $torrent->setId(3);
        $torrent->setSubmitterId(64513);
        $torrent->setInfoHash("henk");
        $torrent->setTorrentTitle("[HorribleSubs] Kabaneri of the Iron Fortress - 12 [1080p].mkv");
        $torrent->save();

        $torrent = new Torrent();
        $torrent->setId(4);
        $torrent->setSubmitterId(64513);
        $torrent->setInfoHash("henk");
        $torrent->setTorrentTitle("[HorribleSubs] Kabaneri of the Iron Fortress - 12 [1080p].mkv");
        $torrent->createMetadata();
        $torrent->setTorrentTitle("[HorribleSubs] Kabaneri of the Iron Fortress - 16 [1080p].mkv");
        $torrent->save();

        $torrent = new Torrent();
        $torrent->setId(5);
        $torrent->setSubmitterId(64513);
        $torrent->setInfoHash("henk");
        $torrent->setTorrentTitle("[HorribleSubs] Kabaneri of the Iron Fortress - 12 [1080p].mkv");
        $torrent->createMetadata();
        $torrent->save();
    }

    public function testUpdater() {
        $updater = new Updater($this->container);
        $updater->run();
        $torrent = TorrentQuery::create()->findOneById(3);
        $this->assertNotNull($torrent->getTorrentMetadata());
        $torrent2 = TorrentQuery::create()->findOneById(4);
        $metadata = $torrent2->getTorrentMetadata();
        $this->assertNotNull($metadata);
        $this->assertEquals([16], $metadata->getEp());
    }

    public function tearDown()
    {
        TorrentMetadataQuery::create()->deleteAll();
        TorrentQuery::create()->deleteAll();
    }
}
