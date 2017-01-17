<?php


namespace Odango\Hebi\Test\AniDB;


use Odango\Hebi\AniDB\TitleCollection;


class TitleCollectionTest extends \PHPUnit_Framework_TestCase
{
    public function testEmptyCollection() {
        $collection = new TitleCollection();
        $this->assertNull($collection->getMainTitleName());
    }
}
