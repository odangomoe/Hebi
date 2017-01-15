<?php


namespace Odango\Hebi\Nyaa;

use Bcn\Component\Json\Reader;
use Odango\Hebi\Model\Map\TorrentTableMap;
use Odango\Hebi\Model\Torrent;
use Odango\Hebi\Model\TorrentQuery;
use Pimple\Container;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Propel;

class Iterator
{
    protected $container;
    protected $config;
    private $amountInTransaction = 0;
    /** @var  ConnectionInterface */
    private $transactionConnection;
    protected $statusFileHandler;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function start() {
        $this->config = $this->container['config']['nyaa'];
        $this->transactionConnection = Propel::getWriteConnection(TorrentTableMap::DATABASE_NAME);

        $this->statusFileHandler = fopen($this->config['status-file'], 'r');
        $reader = new Reader($this->statusFileHandler);
        $reader->enter(Reader::TYPE_OBJECT);
        $reader->enter("items", Reader::TYPE_ARRAY);
        while ($item = $reader->read()) {
            try {
                echo "Processing torrent#{$item['id']}\n";
                $this->process($item);
            } catch (\Exception $e) {
                echo "torrent#{$item['id']} failed: " . $e->getMessage();
            }
        }

        $reader->leave();
        $reader->leave();
    }

    public function process($item) {
        $id = $item['id'];
        $status = $item['status'];

        if ($status !== 'success' || !$item['hasTorrent']) {
            return;
        }

        $pageInfo = $this->readPageInfo($item);
        if (!$pageInfo->getIsFound()) {
            return;
        }

        if (!in_array($pageInfo->getCategoryId(), $this->config['category'])) {
            return;
        }

        echo "Saving torrent#{$id}\n";

        if ($this->amountInTransaction > 100) {
            $this->transactionConnection->commit();
            $this->amountInTransaction = 0;
        }

        if ($this->amountInTransaction === 0) {
            $this->transactionConnection->beginTransaction();
        }

        $torrentPath = sprintf($this->config['torrent-path'], $id);

        $torrentObj = TorrentQuery::create()->findOneById($id);

        $torrent = file_get_contents($torrentPath);
        $torrentReader = TorrentReader::createFromTorrent($torrent);

        if ($torrentObj === null) {
            $torrentObj = new Torrent();
        } else if (($item['succeededAt'] / 1000) <= floatval($torrentObj->getDateCrawled('U.u'))) {
            return;
        }

        $torrentObj->setDateCrawled($item['succeededAt'] / 1000);
        $torrentObj->setTrackers($torrentReader->getTrackers());
        $torrentObj->setInfoHash($torrentReader->getInfoHash());
        $torrentObj->setTorrentTitle($pageInfo->getTitle());
        $torrentObj->setCachedTorrentFile($torrentPath);
        $torrentObj->setSubmitterId($pageInfo->getSubmitterId());
        $torrentObj->save($this->transactionConnection);
        $torrentObj->createMetadata($this->transactionConnection);
        echo "Saved torrent#" . $id . "\n";
        $this->amountInTransaction++;
    }

    public function readPageInfo($item): PageInfo {
        $pagePath = sprintf($this->config['page-path'], $item['id']);
        $page = file_get_contents($pagePath);

        if (!$page) {
            throw new \Exception("Couldn't read the page of torrent#" . $item['id']);
        }

        /** @var PageReader $pageReader */
        $pageReader = PageReader::createFromSource($page);

        return $pageReader->extractInfo();
    }
}