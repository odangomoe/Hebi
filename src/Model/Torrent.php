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
    public function createMetadata($conn = null) {
        $metadata = $this->getTorrentMetadata();
        if ($metadata === null) {
            $metadata = new TorrentMetadata();
            $metadata->setTorrent($this);
        }

        $metadata->applyTitle($this->getTorrentTitle());
        $metadata->save($conn);
    }
}
