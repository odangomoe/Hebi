<?php


namespace Odango\Hebi\Nyaa;


use Rych\Bencode\Bencode;

class TorrentReader
{
    private $torrent;

    /**
     * @var array
     */
    private $decoded;

    /**
     * @return array
     */
    public function getDecoded(): array
    {
        return $this->decoded;
    }

    /**
     * @return string
     */
    public function getTorrent(): string
    {
        return $this->torrent;
    }

    /**
     * @param string $torrent
     */
    public function setTorrent(string $torrent)
    {
        $this->decoded = Bencode::decode($torrent);
        $this->torrent = $torrent;
    }

    public function getTrackers(): array {
        $trackers = [];

        $decoded = $this->getDecoded();

        if (isset($decoded['announce'])) {
            $trackers[] = $decoded['announce'];
        }

        if (isset($decoded['announce-list'])) {
            foreach ($decoded['announce-list'] as $trackerList) {
                $trackers = array_merge($trackers, $trackerList);
            }
        }

        return array_values(array_unique($trackers));
    }

    public function getInfoHash(): string {
        return sha1(Bencode::encode($this->getDecoded()['info']));
    }

    static public function createFromTorrent(string $torrent): TorrentReader {
        $reader = new static();
        $reader->setTorrent($torrent);
        return $reader;
    }
}