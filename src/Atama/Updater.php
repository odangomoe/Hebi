<?php


namespace Odango\Hebi\Atama;


use Odango\Hebi\Model\Torrent;
use Odango\Hebi\Model\TorrentQuery;
use Propel\Runtime\Propel;

class Updater
{
    const BATCH_SIZE = 1000;
    const TRANSACTION_SIZE = 1000;


    private $container;
    private $updatedCounter = 0;
    private $counter = 0;
    private $connection;

    public function __construct($container)
    {
	$this->container = $container;
	$this->connection = Propel::getWriteConnection('default');
    }

    public function run() {
        $this->connection->beginTransaction();
        while(count($batch = $this->getNextBatch()) > 0) {
            $this->updateBatch($batch);
        }
	$this->connection->commit();
	$this->container['logger']->debug('Updated ' . $this->updatedCounter . ' torrents');
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

	    if ($updated) {
		$this->updatedCounter++;
	    }

	    if ($this->updatedCounter != 0 && $this->updatedCounter % static::TRANSACTION_SIZE === 0) {
		$this->connection->commit();
                $this->connection->beginTransaction();
	    }
        }
    }
}
