<?php


namespace Odango\Hebi\Test\Model;

use Odango\Hebi\Model\TorrentMetadata;


class TorrentMetadataTest extends \PHPUnit_Framework_TestCase
{

    public function testHasChanged() {
        $md = new TorrentMetadata();
        $md->applyTitle("[HorribleSubs] Kabaneri of the Iron Fortress - 12 [1080p].mkv");
        $md2 = clone $md;
        $this->assertFalse($md2->hasChanged($md));
        $md2->applyTitle("[HorribleSubs] Kabaneri of the Iron Fortress - 12 [1080p].mkv");
        $this->assertFalse($md2->hasChanged($md));
        $md2->applyTitle("[HorribleSubs] Kabaneri of the Iron Fortress - 16 [1080p].mkv");
        $this->assertTrue($md2->hasChanged($md));
    }
}
