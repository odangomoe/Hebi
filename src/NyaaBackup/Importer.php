<?php


namespace Odango\Hebi\NyaaBackup;


use Odango\Hebi\Model\Torrent;
use Odango\Hebi\Model\TorrentQuery;
use Propel\Runtime\Propel;

class Importer
{
    private $connection;

    private $container;

    public function __construct($container)
    {
        $this->container = $container;
        $this->connection = new \PDO($container['config']['nyaa-backup']['dsn']);
    }

    public function run()
    {
        $statement = $this->connection->query('SELECT * FROM torrents WHERE category_id = 1 AND sub_category_id = 2 ORDER BY id ASC');

        if ($statement === false) {
            echo "Failed import.\n";
            var_dump($this->connection->errorInfo());
        }

        $writeConn = Propel::getWriteConnection('default');

        $torrentBatch = [];
        while($torrentRow = $statement->fetch(\PDO::FETCH_ASSOC)) {
            $torrent = TorrentQuery::create()->findOneById($torrentRow['id']);

            if ($torrent) {
                continue;
            }

            $torrent = new Torrent();
            $torrent->setId($torrentRow['id']);
            $title = htmlspecialchars_decode($torrentRow['name'], ENT_QUOTES | ENT_HTML5);

            $title = preg_replace_callback('~&#([A-F0-9x]+);~', function ($match) {
                $part = $match[1];
                if ($part[0] === 'x') {
                    return chr(intval(substr($part, 1), 16));
                }

                return chr(intval($part));
            }, $title);

            $torrent->setTorrentTitle($title);
            $torrent->setInfoHash($torrentRow['info_hash']);
            $torrent->setDateCrawled(new \DateTime());
            $torrent->setSubmitterId($torrentRow['uploader_id']);
            $torrent->setTrackers([]);

            $torrentBatch[] = $torrent;

            if (count($torrentBatch) === 100) {
                $writeConn->beginTransaction();

                $ids = [];

                /** @var Torrent $torrent */
                foreach ($torrentBatch as $torrent) {
                    $torrent->save($writeConn);
                    $torrent->createMetadata($writeConn);

                    $ids[] = $torrent->getId();
                }

                echo 'Imported torrents with id ' . implode(', ', $ids) . "\n";
                $writeConn->commit();

                $torrentBatch = [];
            }
        }


        $writeConn->beginTransaction();

        $ids = [];

        /** @var Torrent $torrent */
        foreach ($torrentBatch as $torrent) {
            $torrent->save($writeConn);
            $torrent->createMetadata($writeConn);

            $ids[] = $torrent->getId();
        }

        echo 'Imported torrents with id ' . implode(', ', $ids) . "\n";
        $writeConn->commit();

        exit(0);
    }
}