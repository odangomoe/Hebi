<?php


namespace Odango\Hebi\AniDB;


use GuzzleHttp\Client;
use Odango\Hebi\Model\AnimeTitle;
use Odango\Hebi\Model\Base\AnimeTitleQuery;
use Odango\Hebi\Model\Map\AnimeTitleTableMap;
use Propel\Runtime\Propel;

class Importer
{
    private $container;
    private $connection;

    public function __construct($container)
    {
        $this->container = $container;
        $this->config = $container['config']['anidb'] ?? [];
    }

    public function run() {
        $this->boot();
        $path = $this->download();
        $this->clear();
        $this->import($path);
        $this->finish();
    }

    public function finish() {
        $this->connection->commit();
    }

    public function boot() {
        $conn = Propel::getWriteConnection('default');
        $conn->beginTransaction();
        $this->connection = $conn;
    }

    public function download(): string {
        $path = tempnam(sys_get_temp_dir(), 'hebi-ani').'.xml';

        $client = $this->container['guzzle'];
        $client->request(
            'GET',
            $this->config['dump-url'],
            [
                'sink' => $path
            ]
        );

        return $path;
    }

    public function import($xml) {
        $source = file_get_contents($xml);
        $collections = DumpReader::createFromSource($source)->getAllTitleCollections();

        foreach ($collections as $collection) {
            if (count($collection->getTitles()) > 0) {
                $collection->save($this->connection);
            }
        }
    }

    public function clear() {
        AnimeTitleQuery::create()->deleteAll($this->connection);
    }
}