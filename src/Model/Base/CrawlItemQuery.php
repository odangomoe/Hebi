<?php

namespace Odango\Hebi\Model\Base;

use \Exception;
use \PDO;
use Odango\Hebi\Model\CrawlItem as ChildCrawlItem;
use Odango\Hebi\Model\CrawlItemQuery as ChildCrawlItemQuery;
use Odango\Hebi\Model\Map\CrawlItemTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'crawl_item' table.
 *
 *
 *
 * @method     ChildCrawlItemQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildCrawlItemQuery orderByTarget($order = Criteria::ASC) Order by the target column
 * @method     ChildCrawlItemQuery orderByExternalId($order = Criteria::ASC) Order by the external_id column
 * @method     ChildCrawlItemQuery orderByStatus($order = Criteria::ASC) Order by the status column
 * @method     ChildCrawlItemQuery orderByType($order = Criteria::ASC) Order by the type column
 * @method     ChildCrawlItemQuery orderByLastUpdated($order = Criteria::ASC) Order by the last_updated column
 * @method     ChildCrawlItemQuery orderByLastSuccess($order = Criteria::ASC) Order by the last_success column
 * @method     ChildCrawlItemQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 *
 * @method     ChildCrawlItemQuery groupById() Group by the id column
 * @method     ChildCrawlItemQuery groupByTarget() Group by the target column
 * @method     ChildCrawlItemQuery groupByExternalId() Group by the external_id column
 * @method     ChildCrawlItemQuery groupByStatus() Group by the status column
 * @method     ChildCrawlItemQuery groupByType() Group by the type column
 * @method     ChildCrawlItemQuery groupByLastUpdated() Group by the last_updated column
 * @method     ChildCrawlItemQuery groupByLastSuccess() Group by the last_success column
 * @method     ChildCrawlItemQuery groupByCreatedAt() Group by the created_at column
 *
 * @method     ChildCrawlItemQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildCrawlItemQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildCrawlItemQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildCrawlItemQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildCrawlItemQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildCrawlItemQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildCrawlItemQuery leftJoinTorrent($relationAlias = null) Adds a LEFT JOIN clause to the query using the Torrent relation
 * @method     ChildCrawlItemQuery rightJoinTorrent($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Torrent relation
 * @method     ChildCrawlItemQuery innerJoinTorrent($relationAlias = null) Adds a INNER JOIN clause to the query using the Torrent relation
 *
 * @method     ChildCrawlItemQuery joinWithTorrent($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Torrent relation
 *
 * @method     ChildCrawlItemQuery leftJoinWithTorrent() Adds a LEFT JOIN clause and with to the query using the Torrent relation
 * @method     ChildCrawlItemQuery rightJoinWithTorrent() Adds a RIGHT JOIN clause and with to the query using the Torrent relation
 * @method     ChildCrawlItemQuery innerJoinWithTorrent() Adds a INNER JOIN clause and with to the query using the Torrent relation
 *
 * @method     \Odango\Hebi\Model\TorrentQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildCrawlItem findOne(ConnectionInterface $con = null) Return the first ChildCrawlItem matching the query
 * @method     ChildCrawlItem findOneOrCreate(ConnectionInterface $con = null) Return the first ChildCrawlItem matching the query, or a new ChildCrawlItem object populated from the query conditions when no match is found
 *
 * @method     ChildCrawlItem findOneById(string $id) Return the first ChildCrawlItem filtered by the id column
 * @method     ChildCrawlItem findOneByTarget(string $target) Return the first ChildCrawlItem filtered by the target column
 * @method     ChildCrawlItem findOneByExternalId(string $external_id) Return the first ChildCrawlItem filtered by the external_id column
 * @method     ChildCrawlItem findOneByStatus(string $status) Return the first ChildCrawlItem filtered by the status column
 * @method     ChildCrawlItem findOneByType(string $type) Return the first ChildCrawlItem filtered by the type column
 * @method     ChildCrawlItem findOneByLastUpdated(string $last_updated) Return the first ChildCrawlItem filtered by the last_updated column
 * @method     ChildCrawlItem findOneByLastSuccess(string $last_success) Return the first ChildCrawlItem filtered by the last_success column
 * @method     ChildCrawlItem findOneByCreatedAt(string $created_at) Return the first ChildCrawlItem filtered by the created_at column *

 * @method     ChildCrawlItem requirePk($key, ConnectionInterface $con = null) Return the ChildCrawlItem by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCrawlItem requireOne(ConnectionInterface $con = null) Return the first ChildCrawlItem matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildCrawlItem requireOneById(string $id) Return the first ChildCrawlItem filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCrawlItem requireOneByTarget(string $target) Return the first ChildCrawlItem filtered by the target column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCrawlItem requireOneByExternalId(string $external_id) Return the first ChildCrawlItem filtered by the external_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCrawlItem requireOneByStatus(string $status) Return the first ChildCrawlItem filtered by the status column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCrawlItem requireOneByType(string $type) Return the first ChildCrawlItem filtered by the type column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCrawlItem requireOneByLastUpdated(string $last_updated) Return the first ChildCrawlItem filtered by the last_updated column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCrawlItem requireOneByLastSuccess(string $last_success) Return the first ChildCrawlItem filtered by the last_success column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCrawlItem requireOneByCreatedAt(string $created_at) Return the first ChildCrawlItem filtered by the created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildCrawlItem[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildCrawlItem objects based on current ModelCriteria
 * @method     ChildCrawlItem[]|ObjectCollection findById(string $id) Return ChildCrawlItem objects filtered by the id column
 * @method     ChildCrawlItem[]|ObjectCollection findByTarget(string $target) Return ChildCrawlItem objects filtered by the target column
 * @method     ChildCrawlItem[]|ObjectCollection findByExternalId(string $external_id) Return ChildCrawlItem objects filtered by the external_id column
 * @method     ChildCrawlItem[]|ObjectCollection findByStatus(string $status) Return ChildCrawlItem objects filtered by the status column
 * @method     ChildCrawlItem[]|ObjectCollection findByType(string $type) Return ChildCrawlItem objects filtered by the type column
 * @method     ChildCrawlItem[]|ObjectCollection findByLastUpdated(string $last_updated) Return ChildCrawlItem objects filtered by the last_updated column
 * @method     ChildCrawlItem[]|ObjectCollection findByLastSuccess(string $last_success) Return ChildCrawlItem objects filtered by the last_success column
 * @method     ChildCrawlItem[]|ObjectCollection findByCreatedAt(string $created_at) Return ChildCrawlItem objects filtered by the created_at column
 * @method     ChildCrawlItem[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class CrawlItemQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Odango\Hebi\Model\Base\CrawlItemQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Odango\\Hebi\\Model\\CrawlItem', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildCrawlItemQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildCrawlItemQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildCrawlItemQuery) {
            return $criteria;
        }
        $query = new ChildCrawlItemQuery();
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
     * @return ChildCrawlItem|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(CrawlItemTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = CrawlItemTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildCrawlItem A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, target, external_id, status, type, last_updated, last_success, created_at FROM crawl_item WHERE id = :p0';
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
            /** @var ChildCrawlItem $obj */
            $obj = new ChildCrawlItem();
            $obj->hydrate($row);
            CrawlItemTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildCrawlItem|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildCrawlItemQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(CrawlItemTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildCrawlItemQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(CrawlItemTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildCrawlItemQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(CrawlItemTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(CrawlItemTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CrawlItemTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the target column
     *
     * Example usage:
     * <code>
     * $query->filterByTarget('fooValue');   // WHERE target = 'fooValue'
     * $query->filterByTarget('%fooValue%', Criteria::LIKE); // WHERE target LIKE '%fooValue%'
     * </code>
     *
     * @param     string $target The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCrawlItemQuery The current query, for fluid interface
     */
    public function filterByTarget($target = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($target)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CrawlItemTableMap::COL_TARGET, $target, $comparison);
    }

    /**
     * Filter the query on the external_id column
     *
     * Example usage:
     * <code>
     * $query->filterByExternalId('fooValue');   // WHERE external_id = 'fooValue'
     * $query->filterByExternalId('%fooValue%', Criteria::LIKE); // WHERE external_id LIKE '%fooValue%'
     * </code>
     *
     * @param     string $externalId The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCrawlItemQuery The current query, for fluid interface
     */
    public function filterByExternalId($externalId = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($externalId)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CrawlItemTableMap::COL_EXTERNAL_ID, $externalId, $comparison);
    }

    /**
     * Filter the query on the status column
     *
     * Example usage:
     * <code>
     * $query->filterByStatus('fooValue');   // WHERE status = 'fooValue'
     * $query->filterByStatus('%fooValue%', Criteria::LIKE); // WHERE status LIKE '%fooValue%'
     * </code>
     *
     * @param     string $status The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCrawlItemQuery The current query, for fluid interface
     */
    public function filterByStatus($status = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($status)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CrawlItemTableMap::COL_STATUS, $status, $comparison);
    }

    /**
     * Filter the query on the type column
     *
     * Example usage:
     * <code>
     * $query->filterByType('fooValue');   // WHERE type = 'fooValue'
     * $query->filterByType('%fooValue%', Criteria::LIKE); // WHERE type LIKE '%fooValue%'
     * </code>
     *
     * @param     string $type The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCrawlItemQuery The current query, for fluid interface
     */
    public function filterByType($type = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($type)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CrawlItemTableMap::COL_TYPE, $type, $comparison);
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
     * @return $this|ChildCrawlItemQuery The current query, for fluid interface
     */
    public function filterByLastUpdated($lastUpdated = null, $comparison = null)
    {
        if (is_array($lastUpdated)) {
            $useMinMax = false;
            if (isset($lastUpdated['min'])) {
                $this->addUsingAlias(CrawlItemTableMap::COL_LAST_UPDATED, $lastUpdated['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($lastUpdated['max'])) {
                $this->addUsingAlias(CrawlItemTableMap::COL_LAST_UPDATED, $lastUpdated['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CrawlItemTableMap::COL_LAST_UPDATED, $lastUpdated, $comparison);
    }

    /**
     * Filter the query on the last_success column
     *
     * Example usage:
     * <code>
     * $query->filterByLastSuccess('2011-03-14'); // WHERE last_success = '2011-03-14'
     * $query->filterByLastSuccess('now'); // WHERE last_success = '2011-03-14'
     * $query->filterByLastSuccess(array('max' => 'yesterday')); // WHERE last_success > '2011-03-13'
     * </code>
     *
     * @param     mixed $lastSuccess The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCrawlItemQuery The current query, for fluid interface
     */
    public function filterByLastSuccess($lastSuccess = null, $comparison = null)
    {
        if (is_array($lastSuccess)) {
            $useMinMax = false;
            if (isset($lastSuccess['min'])) {
                $this->addUsingAlias(CrawlItemTableMap::COL_LAST_SUCCESS, $lastSuccess['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($lastSuccess['max'])) {
                $this->addUsingAlias(CrawlItemTableMap::COL_LAST_SUCCESS, $lastSuccess['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CrawlItemTableMap::COL_LAST_SUCCESS, $lastSuccess, $comparison);
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
     * @return $this|ChildCrawlItemQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(CrawlItemTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(CrawlItemTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CrawlItemTableMap::COL_CREATED_AT, $createdAt, $comparison);
    }

    /**
     * Filter the query by a related \Odango\Hebi\Model\Torrent object
     *
     * @param \Odango\Hebi\Model\Torrent|ObjectCollection $torrent the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCrawlItemQuery The current query, for fluid interface
     */
    public function filterByTorrent($torrent, $comparison = null)
    {
        if ($torrent instanceof \Odango\Hebi\Model\Torrent) {
            return $this
                ->addUsingAlias(CrawlItemTableMap::COL_ID, $torrent->getCrawlItemId(), $comparison);
        } elseif ($torrent instanceof ObjectCollection) {
            return $this
                ->useTorrentQuery()
                ->filterByPrimaryKeys($torrent->getPrimaryKeys())
                ->endUse();
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
     * @return $this|ChildCrawlItemQuery The current query, for fluid interface
     */
    public function joinTorrent($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
    public function useTorrentQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinTorrent($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Torrent', '\Odango\Hebi\Model\TorrentQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildCrawlItem $crawlItem Object to remove from the list of results
     *
     * @return $this|ChildCrawlItemQuery The current query, for fluid interface
     */
    public function prune($crawlItem = null)
    {
        if ($crawlItem) {
            $this->addUsingAlias(CrawlItemTableMap::COL_ID, $crawlItem->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the crawl_item table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CrawlItemTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            CrawlItemTableMap::clearInstancePool();
            CrawlItemTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(CrawlItemTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(CrawlItemTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            CrawlItemTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            CrawlItemTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     $this|ChildCrawlItemQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(CrawlItemTableMap::COL_LAST_UPDATED, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     $this|ChildCrawlItemQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(CrawlItemTableMap::COL_LAST_UPDATED);
    }

    /**
     * Order by update date asc
     *
     * @return     $this|ChildCrawlItemQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(CrawlItemTableMap::COL_LAST_UPDATED);
    }

    /**
     * Order by create date desc
     *
     * @return     $this|ChildCrawlItemQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(CrawlItemTableMap::COL_CREATED_AT);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     $this|ChildCrawlItemQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(CrawlItemTableMap::COL_CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by create date asc
     *
     * @return     $this|ChildCrawlItemQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(CrawlItemTableMap::COL_CREATED_AT);
    }

} // CrawlItemQuery
