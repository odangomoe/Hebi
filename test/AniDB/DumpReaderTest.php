<?php


namespace Odango\Hebi\Test\AniDB;


use Odango\Hebi\AniDB\DumpReader;

class DumpReaderTest extends \PHPUnit_Framework_TestCase
{

    public function testReading()
    {
        $xml = file_get_contents(__DIR__ . '/../data/example-anidb-dump.xml');
        /** @var DumpReader $dr */
        $dr = DumpReader::createFromSource($xml);
        $titleCollections = $dr->getAllTitleCollections();
        $this->assertCount(3, $titleCollections);
        $first = $titleCollections[0];
        $this->assertEquals(1, $first->getAnimeId());
        $this->assertEquals("Seikai no Monshou", $first->getMainTitleName());
        $this->assertEquals("Seikai no Monshou", $first->getMainTitleName());
        $this->assertCount(4, $first->getTitles());
    }
}
