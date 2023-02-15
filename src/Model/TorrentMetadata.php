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
    public function applyTitle($title)
    {
        $metadata = Metadata::createFromTitle($title);

	foreach ($metadata as $key => $value) {
	    if ($key === "alternative-names") {
                continue;
	    }

            $colName = str_replace('-', '_', $key);
            try {
                $phpName = TorrentMetadataTableMap::translateFieldName(
                    $colName,
                    TorrentMetadataTableMap::TYPE_FIELDNAME,
                    TorrentMetadataTableMap::TYPE_PHPNAME
                );
            } catch (\Exception $e) {
                $this->log('No column for metadata key "'.$key.'"');
                continue;
            }

            // Make sure collection is a -flat- array
            if ($key === 'collection') {
                $value = array_map(
                    function ($item) {
                        return implode(',', $item);
                    },
                    $value
                );
            }

            $func = 'set'.$phpName;
            // DIRTY HACKS
            $this->{$func}($value);
        }
    }

    private function normalizeArray($arr)
    {
        foreach ($arr as $key => $item) {
            if (is_array($item)) {
                $arr[$key] = $this->normalizeArray($item);
            } else {
                $arr[$key] = "{$item}";
            }
        }

        return $arr;
    }

    public function hasChanged(TorrentMetadata $metadata)
    {
        $a = $this->toArray();
        $b = $metadata->toArray();
        $toUnset = ["DateCreated", "LastUpdated"];

        $a = $this->normalizeArray($a);
        $b = $this->normalizeArray($b);

        foreach ($toUnset as $key) {
            unset($a[$key]);
            unset($b[$key]);
        }

        return $a !== $b;
    }
}
