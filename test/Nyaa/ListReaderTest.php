<?php


namespace Odango\Hebi\Test\Nyaa;


use Odango\Hebi\Nyaa\ListReader;

class ListReaderTest extends \PHPUnit_Framework_TestCase
{

    public function testReading()
    {
        $source = file_get_contents(__DIR__ . '/../data/example-nyaa-list.html');
        $listReader = ListReader::createFromSource($source);
        $this->assertEquals(871181, $listReader->getHighestId());
    }
}
