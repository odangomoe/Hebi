<?php


namespace Odango\Hebi\Test\AniDB;


use Odango\Hebi\AniDB\DumpReader;
use Odango\Hebi\Main;
use Odango\Hebi\Model\AnimeTitleQuery;

class DumpReaderTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $main = new Main();
        $main->init('test');
    }

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
        $first->save();
        $firstItems = AnimeTitleQuery::create()->findByAnimeId(1);
        $mainItem = AnimeTitleQuery::create()->filterByAnimeId(1)->findOneByMain(true);
        $this->assertEquals("Seikai no Monshou", $mainItem->getName());
        $this->assertCount(4, $firstItems);
    }
}
