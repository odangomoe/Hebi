<?php

namespace Odango\Hebi\Model;

use Odango\Atama\Metadata;
use Odango\Hebi\Model\Base\TorrentMetadata as BaseTorrentMetadata;
use Odango\Hebi\Model\Map\TorrentMetadataTableMap;

/**
 * Skeleton subclass for representing a row from the 'torrent_metadata' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class TorrentMetadata extends BaseTorrentMetadata
{
    public function applyTitle($title) {
        $metadata = Metadata::createFromTitle($title);

        foreach ($metadata as $key => $value) {
            $colName = str_replace('-', '_', $key);
            try {
                $phpName = TorrentMetadataTableMap::translateFieldName($colName, TorrentMetadataTableMap::TYPE_FIELDNAME, TorrentMetadataTableMap::TYPE_PHPNAME);
            } catch (\Exception $e) {
                $this->log('No column for metadata key "' . $key . '"');
                continue;
            }

            $func = 'set' . $phpName;
            // DIRTY HACKS
            $this->{$func}($value);
        }
    }
}
