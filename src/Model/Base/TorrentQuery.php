<?php

namespace Odango\Hebi\Model\Base;

use \Exception;
use \PDO;
use Odango\Hebi\Model\Torrent as ChildTorrent;
use Odango\Hebi\Model\TorrentQuery as ChildTorrentQuery;
use Odango\Hebi\Model\Map\TorrentTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'torrent' table.
 *
 *
 *
 * @method     ChildTorrentQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildTorrentQuery orderByInfoHash($order = Criteria::ASC) Order by the info_hash column
 * @method     ChildTorrentQuery orderByCachedTorrentFile($order = Criteria::ASC) Order by the cached_torrent_file column
 * @method     ChildTorrentQuery orderByTorrentTitle($order = Criteria::ASC) Order by the torrent_title column
 * @method     ChildTorrentQuery orderBySubmitterId($order = Criteria::ASC) Order by the submitter_id column
 * @method     ChildTorrentQuery orderByTrackers($order = Criteria::ASC) Order by the trackers column
 * @method     ChildTorrentQuery orderByDateCrawled($order = Criteria::ASC) Order by the date_crawled column
 * @method     ChildTorrentQuery orderByLastUpdated($order = Criteria::ASC) Order by the last_updated column
 * @method     ChildTorrentQuery orderByCrawlItemId($order = Criteria::ASC) Order by the crawl_item_id column
 *
 * @method     ChildTorrentQuery groupById() Group by the id column
 * @method     ChildTorrentQuery groupByInfoHash() Group by the info_hash column
 * @method     ChildTorrentQuery groupByCachedTorrentFile() Group by the cached_torrent_file column
 * @method     ChildTorrentQuery groupByTorrentTitle() Group by the torrent_title column
 * @method     ChildTorrentQuery groupBySubmitterId() Group by the submitter_id column
 * @method     ChildTorrentQuery groupByTrackers() Group by the trackers column
 * @method     ChildTorrentQuery groupByDateCrawled() Group by the date_crawled column
 * @method     ChildTorrentQuery groupByLastUpdated() Group by the last_updated column
 * @method     ChildTorrentQuery groupByCrawlItemId() Group by the crawl_item_id column
 *
 * @method     ChildTorrentQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildTorrentQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildTorrentQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildTorrentQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildTorrentQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildTorrentQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildTorrentQuery leftJoinCrawlItem($relationAlias = null) Adds a LEFT JOIN clause to the query using the CrawlItem relation
 * @method     ChildTorrentQuery rightJoinCrawlItem($relationAlias = null) Adds a RIGHT JOIN clause to the query using the CrawlItem relation
 * @method     ChildTorrentQuery innerJoinCrawlItem($relationAlias = null) Adds a INNER JOIN clause to the query using the CrawlItem relation
 *
 * @method     ChildTorrentQuery joinWithCrawlItem($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the CrawlItem relation
 *
 * @method     ChildTorrentQuery leftJoinWithCrawlItem() Adds a LEFT JOIN clause and with to the query using the CrawlItem relation
 * @method     ChildTorrentQuery rightJoinWithCrawlItem() Adds a RIGHT JOIN clause and with to the query using the CrawlItem relation
 * @method     ChildTorrentQuery innerJoinWithCrawlItem() Adds a INNER JOIN clause and with to the query using the CrawlItem relation
 *
 * @method     ChildTorrentQuery leftJoinTorrentStatus($relationAlias = null) Adds a LEFT JOIN clause to the query using the TorrentStatus relation
 * @method     ChildTorrentQuery rightJoinTorrentStatus($relationAlias = null) Adds a RIGHT JOIN clause to the query using the TorrentStatus relation
 * @method     ChildTorrentQuery innerJoinTorrentStatus($relationAlias = null) Adds a INNER JOIN clause to the query using the TorrentStatus relation
 *
 * @method     ChildTorrentQuery joinWithTorrentStatus($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the TorrentStatus relation
 *
 * @method     ChildTorrentQuery leftJoinWithTorrentStatus() Adds a LEFT JOIN clause and with to the query using the TorrentStatus relation
 * @method     ChildTorrentQuery rightJoinWithTorrentStatus() Adds a RIGHT JOIN clause and with to the query using the TorrentStatus relation
 * @method     ChildTorrentQuery innerJoinWithTorrentStatus() Adds a INNER JOIN clause and with to the query using the TorrentStatus relation
 *
 * @method     ChildTorrentQuery leftJoinTorrentMetadata($relationAlias = null) Adds a LEFT JOIN clause to the query using the TorrentMetadata relation
 * @method     ChildTorrentQuery rightJoinTorrentMetadata($relationAlias = null) Adds a RIGHT JOIN clause to the query using the TorrentMetadata relation
 * @method     ChildTorrentQuery innerJoinTorrentMetadata($relationAlias = null) Adds a INNER JOIN clause to the query using the TorrentMetadata relation
 *
 * @method     ChildTorrentQuery joinWithTorrentMetadata($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the TorrentMetadata relation
 *
 * @method     ChildTorrentQuery leftJoinWithTorrentMetadata() Adds a LEFT JOIN clause and with to the query using the TorrentMetadata relation
 * @method     ChildTorrentQuery rightJoinWithTorrentMetadata() Adds a RIGHT JOIN clause and with to the query using the TorrentMetadata relation
 * @method     ChildTorrentQuery innerJoinWithTorrentMetadata() Adds a INNER JOIN clause and with to the query using the TorrentMetadata relation
 *
 * @method     \Odango\Hebi\Model\CrawlItemQuery|\Odango\Hebi\Model\TorrentStatusQuery|\Odango\Hebi\Model\TorrentMetadataQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildTorrent findOne(ConnectionInterface $con = null) Return the first ChildTorrent matching the query
 * @method     ChildTorrent findOneOrCreate(ConnectionInterface $con = null) Return the first ChildTorrent matching the query, or a new ChildTorrent object populated from the query conditions when no match is found
 *
 * @method     ChildTorrent findOneById(string $id) Return the first ChildTorrent filtered by the id column
 * @method     ChildTorrent findOneByInfoHash(string $info_hash) Return the first ChildTorrent filtered by the info_hash column
 * @method     ChildTorrent findOneByCachedTorrentFile(string $cached_torrent_file) Return the first ChildTorrent filtered by the cached_torrent_file column
 * @method     ChildTorrent findOneByTorrentTitle(string $torrent_title) Return the first ChildTorrent filtered by the torrent_title column
 * @method     ChildTorrent findOneBySubmitterId(string $submitter_id) Return the first ChildTorrent filtered by the submitter_id column
 * @method     ChildTorrent findOneByTrackers(array $trackers) Return the first ChildTorrent filtered by the trackers column
 * @method     ChildTorrent findOneByDateCrawled(string $date_crawled) Return the first ChildTorrent filtered by the date_crawled column
 * @method     ChildTorrent findOneByLastUpdated(string $last_updated) Return the first ChildTorrent filtered by the last_updated column
 * @method     ChildTorrent findOneByCrawlItemId(string $crawl_item_id) Return the first ChildTorrent filtered by the crawl_item_id column *

 * @method     ChildTorrent requirePk($key, ConnectionInterface $con = null) Return the ChildTorrent by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTorrent requireOne(ConnectionInterface $con = null) Return the first ChildTorrent matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildTorrent requireOneById(string $id) Return the first ChildTorrent filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTorrent requireOneByInfoHash(string $info_hash) Return the first ChildTorrent filtered by the info_hash column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTorrent requireOneByCachedTorrentFile(string $cached_torrent_file) Return the first ChildTorrent filtered by the cached_torrent_file column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTorrent requireOneByTorrentTitle(string $torrent_title) Return the first ChildTorrent filtered by the torrent_title column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTorrent requireOneBySubmitterId(string $submitter_id) Return the first ChildTorrent filtered by the submitter_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTorrent requireOneByTrackers(array $trackers) Return the first ChildTorrent filtered by the trackers column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTorrent requireOneByDateCrawled(string $date_crawled) Return the first ChildTorrent filtered by the date_crawled column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTorrent requireOneByLastUpdated(string $last_updated) Return the first ChildTorrent filtered by the last_updated column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTorrent requireOneByCrawlItemId(string $crawl_item_id) Return the first ChildTorrent filtered by the crawl_item_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildTorrent[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildTorrent objects based on current ModelCriteria
 * @method     ChildTorrent[]|ObjectCollection findById(string $id) Return ChildTorrent objects filtered by the id column
 * @method     ChildTorrent[]|ObjectCollection findByInfoHash(string $info_hash) Return ChildTorrent objects filtered by the info_hash column
 * @method     ChildTorrent[]|ObjectCollection findByCachedTorrentFile(string $cached_torrent_file) Return ChildTorrent objects filtered by the cached_torrent_file column
 * @method     ChildTorrent[]|ObjectCollection findByTorrentTitle(string $torrent_title) Return ChildTorrent objects filtered by the torrent_title column
 * @method     ChildTorrent[]|ObjectCollection findBySubmitterId(string $submitter_id) Return ChildTorrent objects filtered by the submitter_id column
 * @method     ChildTorrent[]|ObjectCollection findByTrackers(array $trackers) Return ChildTorrent objects filtered by the trackers column
 * @method     ChildTorrent[]|ObjectCollection findByDateCrawled(string $date_crawled) Return ChildTorrent objects filtered by the date_crawled column
 * @method     ChildTorrent[]|ObjectCollection findByLastUpdated(string $last_updated) Return ChildTorrent objects filtered by the last_updated column
 * @method     ChildTorrent[]|ObjectCollection findByCrawlItemId(string $crawl_item_id) Return ChildTorrent objects filtered by the crawl_item_id column
 * @method     ChildTorrent[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class TorrentQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Odango\Hebi\Model\Base\TorrentQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Odango\\Hebi\\Model\\Torrent', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildTorrentQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildTorrentQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildTorrentQuery) {
            return $criteria;
        }
        $query = new ChildTorrentQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildTorrent|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(TorrentTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = TorrentTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
            // the object is already in the instance pool
            return $obj;
        }

        return $this->findPkSimple($key, $con);
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildTorrent A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, info_hash, cached_torrent_file, torrent_title, submitter_id, trackers, date_crawled, last_updated, crawl_item_id FROM torrent WHERE id = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildTorrent $obj */
            $obj = new ChildTorrent();
            $obj->hydrate($row);
            TorrentTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildTorrent|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, ConnectionInterface $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return $this|ChildTorrentQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(TorrentTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildTorrentQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(TorrentTableMap::COL_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id > 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTorrentQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(TorrentTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(TorrentTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TorrentTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the info_hash column
     *
     * Example usage:
     * <code>
     * $query->filterByInfoHash('fooValue');   // WHERE info_hash = 'fooValue'
     * $query->filterByInfoHash('%fooValue%', Criteria::LIKE); // WHERE info_hash LIKE '%fooValue%'
     * </code>
     *
     * @param     string $infoHash The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTorrentQuery The current query, for fluid interface
     */
    public function filterByInfoHash($infoHash = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($infoHash)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TorrentTableMap::COL_INFO_HASH, $infoHash, $comparison);
    }

    /**
     * Filter the query on the cached_torrent_file column
     *
     * Example usage:
     * <code>
     * $query->filterByCachedTorrentFile('fooValue');   // WHERE cached_torrent_file = 'fooValue'
     * $query->filterByCachedTorrentFile('%fooValue%', Criteria::LIKE); // WHERE cached_torrent_file LIKE '%fooValue%'
     * </code>
     *
     * @param     string $cachedTorrentFile The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTorrentQuery The current query, for fluid interface
     */
    public function filterByCachedTorrentFile($cachedTorrentFile = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($cachedTorrentFile)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TorrentTableMap::COL_CACHED_TORRENT_FILE, $cachedTorrentFile, $comparison);
    }

    /**
     * Filter the query on the torrent_title column
     *
     * Example usage:
     * <code>
     * $query->filterByTorrentTitle('fooValue');   // WHERE torrent_title = 'fooValue'
     * $query->filterByTorrentTitle('%fooValue%', Criteria::LIKE); // WHERE torrent_title LIKE '%fooValue%'
     * </code>
     *
     * @param     string $torrentTitle The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTorrentQuery The current query, for fluid interface
     */
    public function filterByTorrentTitle($torrentTitle = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($torrentTitle)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TorrentTableMap::COL_TORRENT_TITLE, $torrentTitle, $comparison);
    }

    /**
     * Filter the query on the submitter_id column
     *
     * Example usage:
     * <code>
     * $query->filterBySubmitterId(1234); // WHERE submitter_id = 1234
     * $query->filterBySubmitterId(array(12, 34)); // WHERE submitter_id IN (12, 34)
     * $query->filterBySubmitterId(array('min' => 12)); // WHERE submitter_id > 12
     * </code>
     *
     * @param     mixed $submitterId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTorrentQuery The current query, for fluid interface
     */
    public function filterBySubmitterId($submitterId = null, $comparison = null)
    {
        if (is_array($submitterId)) {
            $useMinMax = false;
            if (isset($submitterId['min'])) {
                $this->addUsingAlias(TorrentTableMap::COL_SUBMITTER_ID, $submitterId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($submitterId['max'])) {
                $this->addUsingAlias(TorrentTableMap::COL_SUBMITTER_ID, $submitterId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TorrentTableMap::COL_SUBMITTER_ID, $submitterId, $comparison);
    }

    /**
     * Filter the query on the trackers column
     *
     * @param     array $trackers The values to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTorrentQuery The current query, for fluid interface
     */
    public function filterByTrackers($trackers = null, $comparison = null)
    {
        $key = $this->getAliasedColName(TorrentTableMap::COL_TRACKERS);
        if (null === $comparison || $comparison == Criteria::CONTAINS_ALL) {
            foreach ($trackers as $value) {
                $value = '%| ' . $value . ' |%';
                if ($this->containsKey($key)) {
                    $this->addAnd($key, $value, Criteria::LIKE);
                } else {
                    $this->add($key, $value, Criteria::LIKE);
                }
            }

            return $this;
        } elseif ($comparison == Criteria::CONTAINS_SOME) {
            foreach ($trackers as $value) {
                $value = '%| ' . $value . ' |%';
                if ($this->containsKey($key)) {
                    $this->addOr($key, $value, Criteria::LIKE);
                } else {
                    $this->add($key, $value, Criteria::LIKE);
                }
            }

            return $this;
        } elseif ($comparison == Criteria::CONTAINS_NONE) {
            foreach ($trackers as $value) {
                $value = '%| ' . $value . ' |%';
                if ($this->containsKey($key)) {
                    $this->addAnd($key, $value, Criteria::NOT_LIKE);
                } else {
                    $this->add($key, $value, Criteria::NOT_LIKE);
                }
            }
            $this->addOr($key, null, Criteria::ISNULL);

            return $this;
        }

        return $this->addUsingAlias(TorrentTableMap::COL_TRACKERS, $trackers, $comparison);
    }

    /**
     * Filter the query on the trackers column
     * @param     mixed $trackers The value to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::CONTAINS_ALL
     *
     * @return $this|ChildTorrentQuery The current query, for fluid interface
     */
    public function filterByTracker($trackers = null, $comparison = null)
    {
        if (null === $comparison || $comparison == Criteria::CONTAINS_ALL) {
            if (is_scalar($trackers)) {
                $trackers = '%| ' . $trackers . ' |%';
                $comparison = Criteria::LIKE;
            }
        } elseif ($comparison == Criteria::CONTAINS_NONE) {
            $trackers = '%| ' . $trackers . ' |%';
            $comparison = Criteria::NOT_LIKE;
            $key = $this->getAliasedColName(TorrentTableMap::COL_TRACKERS);
            if ($this->containsKey($key)) {
                $this->addAnd($key, $trackers, $comparison);
            } else {
                $this->addAnd($key, $trackers, $comparison);
            }
            $this->addOr($key, null, Criteria::ISNULL);

            return $this;
        }

        return $this->addUsingAlias(TorrentTableMap::COL_TRACKERS, $trackers, $comparison);
    }

    /**
     * Filter the query on the date_crawled column
     *
     * Example usage:
     * <code>
     * $query->filterByDateCrawled('2011-03-14'); // WHERE date_crawled = '2011-03-14'
     * $query->filterByDateCrawled('now'); // WHERE date_crawled = '2011-03-14'
     * $query->filterByDateCrawled(array('max' => 'yesterday')); // WHERE date_crawled > '2011-03-13'
     * </code>
     *
     * @param     mixed $dateCrawled The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTorrentQuery The current query, for fluid interface
     */
    public function filterByDateCrawled($dateCrawled = null, $comparison = null)
    {
        if (is_array($dateCrawled)) {
            $useMinMax = false;
            if (isset($dateCrawled['min'])) {
                $this->addUsingAlias(TorrentTableMap::COL_DATE_CRAWLED, $dateCrawled['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dateCrawled['max'])) {
                $this->addUsingAlias(TorrentTableMap::COL_DATE_CRAWLED, $dateCrawled['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TorrentTableMap::COL_DATE_CRAWLED, $dateCrawled, $comparison);
    }

    /**
     * Filter the query on the last_updated column
     *
     * Example usage:
     * <code>
     * $query->filterByLastUpdated('2011-03-14'); // WHERE last_updated = '2011-03-14'
     * $query->filterByLastUpdated('now'); // WHERE last_updated = '2011-03-14'
     * $query->filterByLastUpdated(array('max' => 'yesterday')); // WHERE last_updated > '2011-03-13'
     * </code>
     *
     * @param     mixed $lastUpdated The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTorrentQuery The current query, for fluid interface
     */
    public function filterByLastUpdated($lastUpdated = null, $comparison = null)
    {
        if (is_array($lastUpdated)) {
            $useMinMax = false;
            if (isset($lastUpdated['min'])) {
                $this->addUsingAlias(TorrentTableMap::COL_LAST_UPDATED, $lastUpdated['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($lastUpdated['max'])) {
                $this->addUsingAlias(TorrentTableMap::COL_LAST_UPDATED, $lastUpdated['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TorrentTableMap::COL_LAST_UPDATED, $lastUpdated, $comparison);
    }

    /**
     * Filter the query on the crawl_item_id column
     *
     * Example usage:
     * <code>
     * $query->filterByCrawlItemId(1234); // WHERE crawl_item_id = 1234
     * $query->filterByCrawlItemId(array(12, 34)); // WHERE crawl_item_id IN (12, 34)
     * $query->filterByCrawlItemId(array('min' => 12)); // WHERE crawl_item_id > 12
     * </code>
     *
     * @see       filterByCrawlItem()
     *
     * @param     mixed $crawlItemId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTorrentQuery The current query, for fluid interface
     */
    public function filterByCrawlItemId($crawlItemId = null, $comparison = null)
    {
        if (is_array($crawlItemId)) {
            $useMinMax = false;
            if (isset($crawlItemId['min'])) {
                $this->addUsingAlias(TorrentTableMap::COL_CRAWL_ITEM_ID, $crawlItemId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($crawlItemId['max'])) {
                $this->addUsingAlias(TorrentTableMap::COL_CRAWL_ITEM_ID, $crawlItemId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TorrentTableMap::COL_CRAWL_ITEM_ID, $crawlItemId, $comparison);
    }

    /**
     * Filter the query by a related \Odango\Hebi\Model\CrawlItem object
     *
     * @param \Odango\Hebi\Model\CrawlItem|ObjectCollection $crawlItem The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildTorrentQuery The current query, for fluid interface
     */
    public function filterByCrawlItem($crawlItem, $comparison = null)
    {
        if ($crawlItem instanceof \Odango\Hebi\Model\CrawlItem) {
            return $this
                ->addUsingAlias(TorrentTableMap::COL_CRAWL_ITEM_ID, $crawlItem->getId(), $comparison);
        } elseif ($crawlItem instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(TorrentTableMap::COL_CRAWL_ITEM_ID, $crawlItem->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByCrawlItem() only accepts arguments of type \Odango\Hebi\Model\CrawlItem or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the CrawlItem relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildTorrentQuery The current query, for fluid interface
     */
    public function joinCrawlItem($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('CrawlItem');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'CrawlItem');
        }

        return $this;
    }

    /**
     * Use the CrawlItem relation CrawlItem object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Odango\Hebi\Model\CrawlItemQuery A secondary query class using the current class as primary query
     */
    public function useCrawlItemQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinCrawlItem($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'CrawlItem', '\Odango\Hebi\Model\CrawlItemQuery');
    }

    /**
     * Filter the query by a related \Odango\Hebi\Model\TorrentStatus object
     *
     * @param \Odango\Hebi\Model\TorrentStatus|ObjectCollection $torrentStatus the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildTorrentQuery The current query, for fluid interface
     */
    public function filterByTorrentStatus($torrentStatus, $comparison = null)
    {
        if ($torrentStatus instanceof \Odango\Hebi\Model\TorrentStatus) {
            return $this
                ->addUsingAlias(TorrentTableMap::COL_ID, $torrentStatus->getTorrentId(), $comparison);
        } elseif ($torrentStatus instanceof ObjectCollection) {
            return $this
                ->useTorrentStatusQuery()
                ->filterByPrimaryKeys($torrentStatus->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByTorrentStatus() only accepts arguments of type \Odango\Hebi\Model\TorrentStatus or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the TorrentStatus relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildTorrentQuery The current query, for fluid interface
     */
    public function joinTorrentStatus($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('TorrentStatus');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'TorrentStatus');
        }

        return $this;
    }

    /**
     * Use the TorrentStatus relation TorrentStatus object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Odango\Hebi\Model\TorrentStatusQuery A secondary query class using the current class as primary query
     */
    public function useTorrentStatusQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinTorrentStatus($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'TorrentStatus', '\Odango\Hebi\Model\TorrentStatusQuery');
    }

    /**
     * Filter the query by a related \Odango\Hebi\Model\TorrentMetadata object
     *
     * @param \Odango\Hebi\Model\TorrentMetadata|ObjectCollection $torrentMetadata the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildTorrentQuery The current query, for fluid interface
     */
    public function filterByTorrentMetadata($torrentMetadata, $comparison = null)
    {
        if ($torrentMetadata instanceof \Odango\Hebi\Model\TorrentMetadata) {
            return $this
                ->addUsingAlias(TorrentTableMap::COL_ID, $torrentMetadata->getTorrentId(), $comparison);
        } elseif ($torrentMetadata instanceof ObjectCollection) {
            return $this
                ->useTorrentMetadataQuery()
                ->filterByPrimaryKeys($torrentMetadata->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByTorrentMetadata() only accepts arguments of type \Odango\Hebi\Model\TorrentMetadata or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the TorrentMetadata relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildTorrentQuery The current query, for fluid interface
     */
    public function joinTorrentMetadata($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('TorrentMetadata');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'TorrentMetadata');
        }

        return $this;
    }

    /**
     * Use the TorrentMetadata relation TorrentMetadata object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Odango\Hebi\Model\TorrentMetadataQuery A secondary query class using the current class as primary query
     */
    public function useTorrentMetadataQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinTorrentMetadata($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'TorrentMetadata', '\Odango\Hebi\Model\TorrentMetadataQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildTorrent $torrent Object to remove from the list of results
     *
     * @return $this|ChildTorrentQuery The current query, for fluid interface
     */
    public function prune($torrent = null)
    {
        if ($torrent) {
            $this->addUsingAlias(TorrentTableMap::COL_ID, $torrent->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the torrent table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(TorrentTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            TorrentTableMap::clearInstancePool();
            TorrentTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * Performs a DELETE on the database based on the current ModelCriteria
     *
     * @param ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public function delete(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(TorrentTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(TorrentTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            TorrentTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            TorrentTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     $this|ChildTorrentQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(TorrentTableMap::COL_LAST_UPDATED, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     $this|ChildTorrentQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(TorrentTableMap::COL_LAST_UPDATED);
    }

    /**
     * Order by update date asc
     *
     * @return     $this|ChildTorrentQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(TorrentTableMap::COL_LAST_UPDATED);
    }

    /**
     * Order by create date desc
     *
     * @return     $this|ChildTorrentQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(TorrentTableMap::COL_DATE_CRAWLED);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     $this|ChildTorrentQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(TorrentTableMap::COL_DATE_CRAWLED, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by create date asc
     *
     * @return     $this|ChildTorrentQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(TorrentTableMap::COL_DATE_CRAWLED);
    }

} // TorrentQuery
