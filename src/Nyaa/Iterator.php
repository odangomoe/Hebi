<?php


namespace Odango\Hebi\Nyaa;

use Bcn\Component\Json\Reader;
use Monolog\Logger;
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
    protected $statusFileHandler;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    private function getLogger(): Logger {
        return $this->container['logger'];
    }

    public function start() {
        $this->config = $this->container['config']['nyaa'];

        $this->statusFileHandler = fopen($this->config['status-file'], 'r');
        $reader = new Reader($this->statusFileHandler);
        $reader->enter(Reader::TYPE_OBJECT);
        $reader->enter("items", Reader::TYPE_ARRAY);
        while ($item = $reader->read()) {
            try {
                $this->getLogger()->debug("Processing torrent#{$item['id']}");
                $this->process($item);
            } catch (\Exception $e) {
                $this->getLogger()->debug("torrent#{$item['id']} failed: " . $e->getMessage());
            }
        }

        $reader->leave();
        $reader->leave();
    }

    public function process($item) {
        $id = $item['id'];
        $status = $item['status'];

        if ($status !== 'success' || !$item['hasTorrent']) {
            $this->getLogger()->debug("Quiting early for torrent#{$id}");
            return;
        }

        $pageInfo = $this->readPageInfo($item);
        if (!$pageInfo->getIsFound()) {
            $this->getLogger()->debug("Hit not found page for torrent#{$id}");
            return;
        }

        $cg = $pageInfo->getCategoryId();
        $acg = implode(', ', $this->config['category']);
        if (!in_array($cg, $this->config['category'])) {
            $this->getLogger()->debug("Wrong category ({$cg} not in {$acg}) for torrent#{$id}");
            return;
        }

        $this->getLogger()->debug("Saving torrent#{$id}");

        $torrentPath = sprintf($this->config['torrent-path'], $id);

        $torrentObj = TorrentQuery::create()->findOneById($id);

        $torrent = file_get_contents($torrentPath);
        $torrentReader = TorrentReader::createFromTorrent($torrent);

        if ($torrentObj === null) {
            $torrentObj = new Torrent();
        } else if (($item['succeededAt'] / 1000) <= floatval($torrentObj->getDateCrawled('U.u'))) {
            return;
        }

        $torrentObj->setId($pageInfo->getTorrentId());
        $torrentObj->setDateCrawled($item['succeededAt'] / 1000);
        $torrentObj->setTrackers($torrentReader->getTrackers());
        $torrentObj->setInfoHash($torrentReader->getInfoHash());
        $torrentObj->setTorrentTitle($pageInfo->getTitle());
        $torrentObj->setCachedTorrentFile($torrentPath);
        $torrentObj->setSubmitterId($pageInfo->getSubmitterId());
        $torrentObj->save();
        $torrentObj->createMetadata();
        $this->getLogger()->debug("Saved torrent#" . $id);
    }

    public function readPageInfo($item): PageInfo {
        $pagePath = sprintf($this->config['page-path'], $item['id']);
        $page = file_get_contents($pagePath);

        /** @var PageReader $pageReader */
        $pageReader = PageReader::createFromSource($page);

        return $pageReader->extractInfo();
    }
}