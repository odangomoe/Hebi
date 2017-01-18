<?php

namespace Odango\Hebi\Model;

use Odango\Hebi\Model\Base\Torrent as BaseTorrent;

/**
 * Skeleton subclass for representing a row from the 'torrent' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class Torrent extends BaseTorrent
{
    public function createMetadata($conn = null): bool {
        $metadata = $this->getTorrentMetadata();
        $oldMetadata = null;
        if ($metadata === null) {
            $metadata = new TorrentMetadata();
        } else {
            $oldMetadata = clone $metadata;
            $metadata->clear();
            $metadata->setNew(false);
            $metadata->setDateCreated($oldMetadata->getDateCreated());
        }

        $metadata->setTorrent($this);
        $metadata->applyTitle($this->getTorrentTitle());

        if ($oldMetadata === null || $metadata->hasChanged($oldMetadata)) {
            $metadata->save($conn);
            return true;
        }

        return false;
    }

    /**
     * Fixes a bug in PropelORM generator
     */
    public function removeTorrentMetadata(){}

    public function setTrackers($v)
    {
        $this->setMainTracker(reset($v));
        return parent::setTrackers($v);
    }
}
