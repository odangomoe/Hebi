<?php


namespace Odango\Hebi\Test\AniDB;


use Odango\Hebi\AniDB\DumpReader;

class DumpReaderTest extends \PHPUnit_Framework_TestCase
{

    public function testReading()
    {
        $xml = file_get_contents(__DIR__ . '/../data/example-anidb-dump.xml');
        $dr = DumpReader::createFromSource($xml);

        $this->assertCount(3, $dr);
    }
}
