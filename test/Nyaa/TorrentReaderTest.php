<?php


namespace Odango\Hebi\Test\Nyaa;


use Odango\Hebi\Nyaa\TorrentReader;

class TorrentReaderTest extends \PHPUnit_Framework_TestCase
{

    public function testReader()
    {
        $torrent = file_get_contents(__DIR__ . '/../data/example-nyaa-torrent.torrent');
        $torrentReader = TorrentReader::createFromTorrent($torrent);

        $this->assertEquals($torrent, $torrentReader->getTorrent());
        $this->assertEquals(['http://open.nyaatorrents.info:6544/announce', 'udp://tracker.openbittorrent.com:80/announce'], $torrentReader->getTrackers());
        $this->assertEquals('32fee1afcb5c3c06c6aeeb4f8fcc6322535e0651', $torrentReader->getInfoHash());
    }
}
