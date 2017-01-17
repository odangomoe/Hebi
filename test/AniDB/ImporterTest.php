<?php


namespace Odango\Hebi\Test\AniDB;


use GuzzleHttp\Client;
use Mockery\Mock;
use Odango\Hebi\AniDB\Importer;
use Odango\Hebi\Main;
use Odango\Hebi\Model\AnimeTitle;
use Odango\Hebi\Model\AnimeTitleQuery;
use Propel\Runtime\Propel;


class ImporterTest extends \PHPUnit_Framework_TestCase
{
    private $container;

    public function setUp()
    {
        $main = new Main();
        $main->init('test');
        $this->container = $main->getContainer();
        $this->container['config'] = [
            'anidb' => [
                'dump-url' => realpath(__DIR__ . '/../data/example-anidb-dump.xml')
            ]
        ];
    }

    public function testImport() {

        $mock = \Mockery::mock(Client::class);
        $mock->shouldReceive('request')->andReturnUsing(function ($method, $url, $options) {
            $path = $this->container['config']['anidb']['dump-url'];
            $this->assertEquals("GET", $method);
            $this->assertEquals($path, $url);
            $this->assertArrayHasKey("sink", $options);
            copy($path, $options['sink']);
        });

        $this->container['guzzle'] = $mock;

        $importer = new Importer($this->container);
        $importer->run();
        $titles = AnimeTitleQuery::create()->filterByMain(true)->groupByAnimeId()->find();
        $this->assertCount(3, $titles);
        AnimeTitleQuery::create()->deleteAll();
    }

    public function testTransaction() {
        $importer = new Importer($this->container);

        $title = new AnimeTitle();
        $title->setName("Test");
        $title->setAnimeId(4);
        $title->save();

        $importer->boot();
        $importer->clear();
        Propel::getWriteConnection('default')->rollBack();
        $title = AnimeTitleQuery::create()->findOneByAnimeId(4);
        $this->assertEquals("Test", $title->getName());
    }
}
