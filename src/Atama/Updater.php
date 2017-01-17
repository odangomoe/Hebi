<?php


namespace Odango\Hebi\Atama;


use Odango\Hebi\Model\Torrent;
use Odango\Hebi\Model\TorrentQuery;

class Updater
{
    const BATCH_SIZE = 100;

    private $container;
    private $counter = 0;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function run() {
        while(count($batch = $this->getNextBatch()) > 0) {
            $this->updateBatch($batch);
        }
    }

    /**
     * @return \Odango\Hebi\Model\Torrent[]
     */
    public function getNextBatch() {
        return TorrentQuery::create()->limit(static::BATCH_SIZE)->offset($this->counter++*static::BATCH_SIZE)->find();
    }

    /**
     * @param $batch Torrent[]
     */
    public function updateBatch($batch) {
        foreach ($batch as $item) {
            $updated = $item->createMetadata();
            $this->container['logger']->debug('Ran Atama over torrent#' . $item->getId() . ': ' . ($updated ? 'Updated' : 'Stale'));
        }
    }
}