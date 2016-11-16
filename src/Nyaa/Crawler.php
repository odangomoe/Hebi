<?php


namespace Odango\Hebi\Nyaa;

use GuzzleHttp\Client;
use GuzzleHttp\Promise\Promise;
use GuzzleHttp\Promise\PromiseInterface;
use League\Flysystem\Filesystem;
use Monolog\Logger;
use Odango\Hebi\Model\CrawlItem;
use Odango\Hebi\Model\CrawlItemQuery;
use Odango\Hebi\Model\Map\CrawlItemTableMap;
use Odango\Hebi\Model\Torrent;
use Odango\Hebi\Scheduler;
use Pimple\Container;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Propel;

class Crawler extends Scheduler
{
    private $beforeDone = false;
    /**
     * @var int[]
     */
    private $batch = [];
    /**
     * @var Container
     */
    private $container;
    /**
     * @var Fetcher
     */
    private $fetcher;

    /**
     * @return Logger
     */
    public function getLogger() {
        return $this->container['logger'];
    }

    public function __construct($container)
    {
        $this->container = $container;
        $this->fetcher = new Fetcher($this->container);
    }

    public function beforeSchedule(callable $callback)
    {
        // Re-init guzzle with proxy
        $this->container['main']->initGuzzle([
            'proxy' => $this->container['config']['nyaa']['proxy'] ?? null,
            'verify' => $this->container['config']['nyaa']['verify_ssl'] ?? true,
        ]);

        $this->getLogger()->info('Using proxy: ' . ($this->container['config']['nyaa']['proxy'] ?? "no"));

        Propel::disableInstancePooling();
        $this->getLogger()->info("Starting nyaa scheduler");
        $this->updateCrawlItems()->then(function () use ($callback) {
            $this->beforeDone = true;
            $this->obtainBatch();
            $callback();
        })->otherwise(function (\Exception $err) {
            $this->beforeDone = true;
            $this->getLogger()->warning('Starting failed: ' . $err->getMessage());
            var_dump($err);
        });
    }

    public function updateCrawlItems() {
        /** @var CrawlItem $latestSaved */
        $latestSaved = CrawlItemQuery::create()->orderByExternalId(Criteria::DESC)->filterByTarget('nyaa')->findOneByType('torrent');
        return $this->fetcher->fetchHighestId()->then(function ($latestId) use ($latestSaved) {
            $lastId = 0;
            if ($latestSaved !== null) {
                $lastId = intval($latestSaved->getExternalId()) + 1;
            }

            $items = $latestId - $lastId;
            if ($items < 1) {
                return;
            }

            $batches = ceil($items / 100);
            $con = Propel::getWriteConnection(CrawlItemTableMap::DATABASE_NAME);

            for ($i = 0; $i < $batches; $i++) {
                $start = $lastId + ($i * 100);
                $this->buildNewCrawlItems($con, $start, min($start + 100, $latestId));
            }

            $this->getLogger()->info("Done creating CrawlItem's from {$lastId} to {$latestId} needed ${batches} batches");
            return;
        });
    }

    public function buildNewCrawlItems(ConnectionInterface $con, $from, $to) {
        $con->beginTransaction();
        $this->getLogger()->info("Creating CrawlItem's from {$from} to {$to}");
        for ($i = $from; $i <= $to; $i++) {
            $item = new CrawlItem();
            $item->setType('torrent');
            $item->setTarget('nyaa');
            $item->setStatus('created');
            $item->setExternalId($i);
            $item->save($con);
        }

        $con->commit();
    }

    public function getBatchSize() {
        return $this->container['config']['nyaa']['batch'] ?? 100;
    }

    public function obtainBatch() {
        $con = Propel::getWriteConnection(CrawlItemTableMap::DATABASE_NAME);
        $con->beginTransaction();
        $ids = CrawlItemQuery::create()
            ->select(['id'])
            ->filterByTarget('nyaa')
            ->filterByType('torrent')
            ->filterByStatus(['created', 'failed'])
            ->orderByStatus(Criteria::ASC)
            ->orderByLastUpdated(Criteria::ASC)
            ->limit($this->getBatchSize())
            ->find()
            ->getArrayCopy();

        CrawlItemQuery::create()
            ->filterById($ids)
            ->update(['Status' => 'queued']);

        $con->commit();

        $this->batch = $ids;
    }

    public function getNextItem()
    {
        return array_shift($this->batch);
    }

    public function hasItems()
    {
        return count($this->batch) > 0;
    }

    public function process($item, callable $callback)
    {
        $this->getLogger()->debug("Starting process for CrawlItem[id={$item}]");
        $crawlItem = CrawlItemQuery::create()->findOneById($item);
        $this->fetcher->fetchPageInfo($crawlItem->getExternalId())->then(
            function ($pageInfo) use ($crawlItem) {
                return $this->processTorrentPage($crawlItem, $pageInfo);
            }
        )->then(function () use ($callback) {
            $callback();
        })->otherwise(function (\Exception $e) use ($crawlItem, $callback) {
            $this->getLogger()->warn("Process for CrawlItem[id={$crawlItem->getId()}] failed: {$e->getMessage()}");
            $crawlItem->fail();
            $callback();
        });
    }

    /**
     * @param CrawlItem $crawlItem
     * @param PageInfo $pageInfo
     * @return Promise|null
     */
    public function processTorrentPage($crawlItem, $pageInfo) {
        /** @var PageInfo $pageInfo */
        if ($pageInfo->getIsFound()) {
            if ($pageInfo->getCategoryId() !== '1_37') {
                $this->getLogger()->debug("Torrent[target=nyaa,ext_id={$crawlItem->getExternalId()}] is not in the desired category");
                $crawlItem->setStatus('wrong-category');
                $crawlItem->save();
                return null;
            }

            $this->getLogger()->debug("Found Torrent[target=nyaa,ext_id={$crawlItem->getExternalId()}]");
            return $this->processTorrentFile($crawlItem, $pageInfo)->then(function () use ($crawlItem) {
                $crawlItem->setStatus('done');
                $crawlItem->save();
                $this->getLogger()->debug("CrawlItem[id={$crawlItem->getId()}] fully done");

                return;
            });
        } else {
            $this->getLogger()->debug("Torrent[target=nyaa,ext_id={$crawlItem->getExternalId()}] doesn't exist");
            $crawlItem->setStatus('not-found');
            $crawlItem->save();
        }

        return null;
    }

    public function onDepletion(callable $callback)
    {
        $this->getLogger()->info("Batch depleted, queueing more items");
        $this->obtainBatch();
        $callback();
    }

    /**
     * @param CrawlItem $crawlItem
     * @param PageInfo $pageInfo
     * @return PromiseInterface
     */
    public function processTorrentFile($crawlItem, $pageInfo): PromiseInterface {
        return $this->fetcher->fetchTorrent($crawlItem->getExternalId())->then(function ($torrent) use ($pageInfo, $crawlItem) {
            $torrentObj = $crawlItem->getTorrent();

            $path = $this->storeTorrent($crawlItem->getExternalId(), $torrent);
            $torrentReader = TorrentReader::createFromTorrent($torrent);

            if ($torrentObj === null) {
                $torrentObj = new Torrent();
            }

            $torrentObj->setTrackers($torrentReader->getTrackers());
            $torrentObj->setInfoHash($torrentReader->getInfoHash());
            $torrentObj->setTorrentTitle($pageInfo->getTitle());
            $torrentObj->setCachedTorrentFile($path);
            $torrentObj->setSubmitterId($pageInfo->getSubmitterId());
            $torrentObj->setCrawlItem($crawlItem);
            $torrentObj->save();
            $torrentObj->createMetadata();

            return $torrentObj;
        });
    }

    public function storeTorrent($id, $torrent) {
        /** @var Filesystem $filesystem */
        $filesystem = $this->container['filesystem'];
        $path = 'torrents/' . substr($id, 0, 2) . '/' . $id . '.torrent';
        $success = $filesystem->write($path, $torrent);
        if ($success === false) {
            throw new \Exception("Failed writing Torrent[ext_id={$id},target=nyaa] to {$path}");
        }

        return $path;
    }

    public function startTicking()
    {
        while(!$this->beforeDone || $this->hasItems() || $this->running > 0) {
            $this->tick();
            usleep(500);
        }
    }

    public function tick()
    {
        $this->fetcher->tick();
    }
}