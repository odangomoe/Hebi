<?php

namespace Odango\Hebi\Model\Base;

use \Exception;
use \PDO;
use Odango\Hebi\Model\TorrentStatus as ChildTorrentStatus;
use Odango\Hebi\Model\TorrentStatusQuery as ChildTorrentStatusQuery;
use Odango\Hebi\Model\Map\TorrentStatusTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'torrent_status' table.
 *
 *
 *
 * @method     ChildTorrentStatusQuery orderByTorrentId($order = Criteria::ASC) Order by the torrent_id column
 * @method     ChildTorrentStatusQuery orderBySuccess($order = Criteria::ASC) Order by the success column
 * @method     ChildTorrentStatusQuery orderByTracker($order = Criteria::ASC) Order by the tracker column
 * @method     ChildTorrentStatusQuery orderBySeeders($order = Criteria::ASC) Order by the seeders column
 * @method     ChildTorrentStatusQuery orderByLeechers($order = Criteria::ASC) Order by the leechers column
 * @method     ChildTorrentStatusQuery orderByDownloaded($order = Criteria::ASC) Order by the downloaded column
 * @method     ChildTorrentStatusQuery orderByLastUpdated($order = Criteria::ASC) Order by the last_updated column
 * @method     ChildTorrentStatusQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 *
 * @method     ChildTorrentStatusQuery groupByTorrentId() Group by the torrent_id column
 * @method     ChildTorrentStatusQuery groupBySuccess() Group by the success column
 * @method     ChildTorrentStatusQuery groupByTracker() Group by the tracker column
 * @method     ChildTorrentStatusQuery groupBySeeders() Group by the seeders column
 * @method     ChildTorrentStatusQuery groupByLeechers() Group by the leechers column
 * @method     ChildTorrentStatusQuery groupByDownloaded() Group by the downloaded column
 * @method     ChildTorrentStatusQuery groupByLastUpdated() Group by the last_updated column
 * @method     ChildTorrentStatusQuery groupByCreatedAt() Group by the created_at column
 *
 * @method     ChildTorrentStatusQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildTorrentStatusQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildTorrentStatusQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildTorrentStatusQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildTorrentStatusQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildTorrentStatusQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildTorrentStatusQuery leftJoinTorrent($relationAlias = null) Adds a LEFT JOIN clause to the query using the Torrent relation
 * @method     ChildTorrentStatusQuery rightJoinTorrent($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Torrent relation
 * @method     ChildTorrentStatusQuery innerJoinTorrent($relationAlias = null) Adds a INNER JOIN clause to the query using the Torrent relation
 *
 * @method     ChildTorrentStatusQuery joinWithTorrent($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Torrent relation
 *
 * @method     ChildTorrentStatusQuery leftJoinWithTorrent() Adds a LEFT JOIN clause and with to the query using the Torrent relation
 * @method     ChildTorrentStatusQuery rightJoinWithTorrent() Adds a RIGHT JOIN clause and with to the query using the Torrent relation
 * @method     ChildTorrentStatusQuery innerJoinWithTorrent() Adds a INNER JOIN clause and with to the query using the Torrent relation
 *
 * @method     \Odango\Hebi\Model\TorrentQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildTorrentStatus findOne(ConnectionInterface $con = null) Return the first ChildTorrentStatus matching the query
 * @method     ChildTorrentStatus findOneOrCreate(ConnectionInterface $con = null) Return the first ChildTorrentStatus matching the query, or a new ChildTorrentStatus object populated from the query conditions when no match is found
 *
 * @method     ChildTorrentStatus findOneByTorrentId(string $torrent_id) Return the first ChildTorrentStatus filtered by the torrent_id column
 * @method     ChildTorrentStatus findOneBySuccess(boolean $success) Return the first ChildTorrentStatus filtered by the success column
 * @method     ChildTorrentStatus findOneByTracker(string $tracker) Return the first ChildTorrentStatus filtered by the tracker column
 * @method     ChildTorrentStatus findOneBySeeders(string $seeders) Return the first ChildTorrentStatus filtered by the seeders column
 * @method     ChildTorrentStatus findOneByLeechers(string $leechers) Return the first ChildTorrentStatus filtered by the leechers column
 * @method     ChildTorrentStatus findOneByDownloaded(string $downloaded) Return the first ChildTorrentStatus filtered by the downloaded column
 * @method     ChildTorrentStatus findOneByLastUpdated(string $last_updated) Return the first ChildTorrentStatus filtered by the last_updated column
 * @method     ChildTorrentStatus findOneByCreatedAt(string $created_at) Return the first ChildTorrentStatus filtered by the created_at column *

 * @method     ChildTorrentStatus requirePk($key, ConnectionInterface $con = null) Return the ChildTorrentStatus by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTorrentStatus requireOne(ConnectionInterface $con = null) Return the first ChildTorrentStatus matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildTorrentStatus requireOneByTorrentId(string $torrent_id) Return the first ChildTorrentStatus filtered by the torrent_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTorrentStatus requireOneBySuccess(boolean $success) Return the first ChildTorrentStatus filtered by the success column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTorrentStatus requireOneByTracker(string $tracker) Return the first ChildTorrentStatus filtered by the tracker column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTorrentStatus requireOneBySeeders(string $seeders) Return the first ChildTorrentStatus filtered by the seeders column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTorrentStatus requireOneByLeechers(string $leechers) Return the first ChildTorrentStatus filtered by the leechers column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTorrentStatus requireOneByDownloaded(string $downloaded) Return the first ChildTorrentStatus filtered by the downloaded column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTorrentStatus requireOneByLastUpdated(string $last_updated) Return the first ChildTorrentStatus filtered by the last_updated column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTorrentStatus requireOneByCreatedAt(string $created_at) Return the first ChildTorrentStatus filtered by the created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildTorrentStatus[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildTorrentStatus objects based on current ModelCriteria
 * @method     ChildTorrentStatus[]|ObjectCollection findByTorrentId(string $torrent_id) Return ChildTorrentStatus objects filtered by the torrent_id column
 * @method     ChildTorrentStatus[]|ObjectCollection findBySuccess(boolean $success) Return ChildTorrentStatus objects filtered by the success column
 * @method     ChildTorrentStatus[]|ObjectCollection findByTracker(string $tracker) Return ChildTorrentStatus objects filtered by the tracker column
 * @method     ChildTorrentStatus[]|ObjectCollection findBySeeders(string $seeders) Return ChildTorrentStatus objects filtered by the seeders column
 * @method     ChildTorrentStatus[]|ObjectCollection findByLeechers(string $leechers) Return ChildTorrentStatus objects filtered by the leechers column
 * @method     ChildTorrentStatus[]|ObjectCollection findByDownloaded(string $downloaded) Return ChildTorrentStatus objects filtered by the downloaded column
 * @method     ChildTorrentStatus[]|ObjectCollection findByLastUpdated(string $last_updated) Return ChildTorrentStatus objects filtered by the last_updated column
 * @method     ChildTorrentStatus[]|ObjectCollection findByCreatedAt(string $created_at) Return ChildTorrentStatus objects filtered by the created_at column
 * @method     ChildTorrentStatus[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class TorrentStatusQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Odango\Hebi\Model\Base\TorrentStatusQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Odango\\Hebi\\Model\\TorrentStatus', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildTorrentStatusQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildTorrentStatusQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildTorrentStatusQuery) {
            return $criteria;
        }
        $query = new ChildTorrentStatusQuery();
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
     * @return ChildTorrentStatus|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(TorrentStatusTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = TorrentStatusTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildTorrentStatus A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT `torrent_id`, `success`, `tracker`, `seeders`, `leechers`, `downloaded`, `last_updated`, `created_at` FROM `torrent_status` WHERE `torrent_id` = :p0';
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
            /** @var ChildTorrentStatus $obj */
            $obj = new ChildTorrentStatus();
            $obj->hydrate($row);
            TorrentStatusTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildTorrentStatus|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildTorrentStatusQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(TorrentStatusTableMap::COL_TORRENT_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildTorrentStatusQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(TorrentStatusTableMap::COL_TORRENT_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the torrent_id column
     *
     * Example usage:
     * <code>
     * $query->filterByTorrentId(1234); // WHERE torrent_id = 1234
     * $query->filterByTorrentId(array(12, 34)); // WHERE torrent_id IN (12, 34)
     * $query->filterByTorrentId(array('min' => 12)); // WHERE torrent_id > 12
     * </code>
     *
     * @see       filterByTorrent()
     *
     * @param     mixed $torrentId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTorrentStatusQuery The current query, for fluid interface
     */
    public function filterByTorrentId($torrentId = null, $comparison = null)
    {
        if (is_array($torrentId)) {
            $useMinMax = false;
            if (isset($torrentId['min'])) {
                $this->addUsingAlias(TorrentStatusTableMap::COL_TORRENT_ID, $torrentId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($torrentId['max'])) {
                $this->addUsingAlias(TorrentStatusTableMap::COL_TORRENT_ID, $torrentId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TorrentStatusTableMap::COL_TORRENT_ID, $torrentId, $comparison);
    }

    /**
     * Filter the query on the success column
     *
     * Example usage:
     * <code>
     * $query->filterBySuccess(true); // WHERE success = true
     * $query->filterBySuccess('yes'); // WHERE success = true
     * </code>
     *
     * @param     boolean|string $success The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTorrentStatusQuery The current query, for fluid interface
     */
    public function filterBySuccess($success = null, $comparison = null)
    {
        if (is_string($success)) {
            $success = in_array(strtolower($success), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(TorrentStatusTableMap::COL_SUCCESS, $success, $comparison);
    }

    /**
     * Filter the query on the tracker column
     *
     * Example usage:
     * <code>
     * $query->filterByTracker('fooValue');   // WHERE tracker = 'fooValue'
     * $query->filterByTracker('%fooValue%', Criteria::LIKE); // WHERE tracker LIKE '%fooValue%'
     * </code>
     *
     * @param     string $tracker The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTorrentStatusQuery The current query, for fluid interface
     */
    public function filterByTracker($tracker = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($tracker)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TorrentStatusTableMap::COL_TRACKER, $tracker, $comparison);
    }

    /**
     * Filter the query on the seeders column
     *
     * Example usage:
     * <code>
     * $query->filterBySeeders(1234); // WHERE seeders = 1234
     * $query->filterBySeeders(array(12, 34)); // WHERE seeders IN (12, 34)
     * $query->filterBySeeders(array('min' => 12)); // WHERE seeders > 12
     * </code>
     *
     * @param     mixed $seeders The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTorrentStatusQuery The current query, for fluid interface
     */
    public function filterBySeeders($seeders = null, $comparison = null)
    {
        if (is_array($seeders)) {
            $useMinMax = false;
            if (isset($seeders['min'])) {
                $this->addUsingAlias(TorrentStatusTableMap::COL_SEEDERS, $seeders['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($seeders['max'])) {
                $this->addUsingAlias(TorrentStatusTableMap::COL_SEEDERS, $seeders['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TorrentStatusTableMap::COL_SEEDERS, $seeders, $comparison);
    }

    /**
     * Filter the query on the leechers column
     *
     * Example usage:
     * <code>
     * $query->filterByLeechers(1234); // WHERE leechers = 1234
     * $query->filterByLeechers(array(12, 34)); // WHERE leechers IN (12, 34)
     * $query->filterByLeechers(array('min' => 12)); // WHERE leechers > 12
     * </code>
     *
     * @param     mixed $leechers The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTorrentStatusQuery The current query, for fluid interface
     */
    public function filterByLeechers($leechers = null, $comparison = null)
    {
        if (is_array($leechers)) {
            $useMinMax = false;
            if (isset($leechers['min'])) {
                $this->addUsingAlias(TorrentStatusTableMap::COL_LEECHERS, $leechers['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($leechers['max'])) {
                $this->addUsingAlias(TorrentStatusTableMap::COL_LEECHERS, $leechers['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TorrentStatusTableMap::COL_LEECHERS, $leechers, $comparison);
    }

    /**
     * Filter the query on the downloaded column
     *
     * Example usage:
     * <code>
     * $query->filterByDownloaded(1234); // WHERE downloaded = 1234
     * $query->filterByDownloaded(array(12, 34)); // WHERE downloaded IN (12, 34)
     * $query->filterByDownloaded(array('min' => 12)); // WHERE downloaded > 12
     * </code>
     *
     * @param     mixed $downloaded The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTorrentStatusQuery The current query, for fluid interface
     */
    public function filterByDownloaded($downloaded = null, $comparison = null)
    {
        if (is_array($downloaded)) {
            $useMinMax = false;
            if (isset($downloaded['min'])) {
                $this->addUsingAlias(TorrentStatusTableMap::COL_DOWNLOADED, $downloaded['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($downloaded['max'])) {
                $this->addUsingAlias(TorrentStatusTableMap::COL_DOWNLOADED, $downloaded['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TorrentStatusTableMap::COL_DOWNLOADED, $downloaded, $comparison);
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
     * @return $this|ChildTorrentStatusQuery The current query, for fluid interface
     */
    public function filterByLastUpdated($lastUpdated = null, $comparison = null)
    {
        if (is_array($lastUpdated)) {
            $useMinMax = false;
            if (isset($lastUpdated['min'])) {
                $this->addUsingAlias(TorrentStatusTableMap::COL_LAST_UPDATED, $lastUpdated['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($lastUpdated['max'])) {
                $this->addUsingAlias(TorrentStatusTableMap::COL_LAST_UPDATED, $lastUpdated['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TorrentStatusTableMap::COL_LAST_UPDATED, $lastUpdated, $comparison);
    }

    /**
     * Filter the query on the created_at column
     *
     * Example usage:
     * <code>
     * $query->filterByCreatedAt('2011-03-14'); // WHERE created_at = '2011-03-14'
     * $query->filterByCreatedAt('now'); // WHERE created_at = '2011-03-14'
     * $query->filterByCreatedAt(array('max' => 'yesterday')); // WHERE created_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $createdAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTorrentStatusQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(TorrentStatusTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(TorrentStatusTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TorrentStatusTableMap::COL_CREATED_AT, $createdAt, $comparison);
    }

    /**
     * Filter the query by a related \Odango\Hebi\Model\Torrent object
     *
     * @param \Odango\Hebi\Model\Torrent|ObjectCollection $torrent The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildTorrentStatusQuery The current query, for fluid interface
     */
    public function filterByTorrent($torrent, $comparison = null)
    {
        if ($torrent instanceof \Odango\Hebi\Model\Torrent) {
            return $this
                ->addUsingAlias(TorrentStatusTableMap::COL_TORRENT_ID, $torrent->getId(), $comparison);
        } elseif ($torrent instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(TorrentStatusTableMap::COL_TORRENT_ID, $torrent->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByTorrent() only accepts arguments of type \Odango\Hebi\Model\Torrent or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Torrent relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildTorrentStatusQuery The current query, for fluid interface
     */
    public function joinTorrent($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Torrent');

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
            $this->addJoinObject($join, 'Torrent');
        }

        return $this;
    }

    /**
     * Use the Torrent relation Torrent object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Odango\Hebi\Model\TorrentQuery A secondary query class using the current class as primary query
     */
    public function useTorrentQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinTorrent($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Torrent', '\Odango\Hebi\Model\TorrentQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildTorrentStatus $torrentStatus Object to remove from the list of results
     *
     * @return $this|ChildTorrentStatusQuery The current query, for fluid interface
     */
    public function prune($torrentStatus = null)
    {
        if ($torrentStatus) {
            $this->addUsingAlias(TorrentStatusTableMap::COL_TORRENT_ID, $torrentStatus->getTorrentId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the torrent_status table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(TorrentStatusTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            TorrentStatusTableMap::clearInstancePool();
            TorrentStatusTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(TorrentStatusTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(TorrentStatusTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            TorrentStatusTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            TorrentStatusTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     $this|ChildTorrentStatusQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(TorrentStatusTableMap::COL_LAST_UPDATED, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     $this|ChildTorrentStatusQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(TorrentStatusTableMap::COL_LAST_UPDATED);
    }

    /**
     * Order by update date asc
     *
     * @return     $this|ChildTorrentStatusQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(TorrentStatusTableMap::COL_LAST_UPDATED);
    }

    /**
     * Order by create date desc
     *
     * @return     $this|ChildTorrentStatusQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(TorrentStatusTableMap::COL_CREATED_AT);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     $this|ChildTorrentStatusQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(TorrentStatusTableMap::COL_CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by create date asc
     *
     * @return     $this|ChildTorrentStatusQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(TorrentStatusTableMap::COL_CREATED_AT);
    }

} // TorrentStatusQuery
