<?php


namespace Odango\Hebo\Test\Nyaa;


use Odango\Hebo\Nyaa\Crawler\PageReader;

class PageReaderTest extends \PHPUnit_Framework_TestCase
{
    public function testInfoExtraction()
    {
        $page = file_get_contents(__DIR__ . '/../data/example-nyaa-page.html');
        $pageReader = PageReader::createFromSource($page);
        $this->assertEquals($page, $pageReader->getSource());
        $info = $pageReader->extractInfo();

        $this->assertEquals("[HorribleSubs] Kabaneri of the Iron Fortress - 12 [1080p].mkv", $info->getTitle());
        $this->assertEquals("HorribleSubs", $info->getSubmitterName());
        $this->assertEquals(64513, $info->getSubmitterId());
        $this->assertEquals('1_37', $info->getCategoryId());
        $this->assertEquals(825702, $info->getTorrentId());
    }
}
