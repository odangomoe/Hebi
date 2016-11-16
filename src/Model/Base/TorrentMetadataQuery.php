<?php

namespace Odango\Hebi\Model\Base;

use \Exception;
use \PDO;
use Odango\Hebi\Model\TorrentMetadata as ChildTorrentMetadata;
use Odango\Hebi\Model\TorrentMetadataQuery as ChildTorrentMetadataQuery;
use Odango\Hebi\Model\Map\TorrentMetadataTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'torrent_metadata' table.
 *
 *
 *
 * @method     ChildTorrentMetadataQuery orderByTorrentId($order = Criteria::ASC) Order by the torrent_id column
 * @method     ChildTorrentMetadataQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method     ChildTorrentMetadataQuery orderByType($order = Criteria::ASC) Order by the type column
 * @method     ChildTorrentMetadataQuery orderByGroup($order = Criteria::ASC) Order by the group column
 * @method     ChildTorrentMetadataQuery orderByUnparsed($order = Criteria::ASC) Order by the unparsed column
 * @method     ChildTorrentMetadataQuery orderByResolution($order = Criteria::ASC) Order by the resolution column
 * @method     ChildTorrentMetadataQuery orderByVideo($order = Criteria::ASC) Order by the video column
 * @method     ChildTorrentMetadataQuery orderByVideoDepth($order = Criteria::ASC) Order by the video_depth column
 * @method     ChildTorrentMetadataQuery orderByAudio($order = Criteria::ASC) Order by the audio column
 * @method     ChildTorrentMetadataQuery orderBySource($order = Criteria::ASC) Order by the source column
 * @method     ChildTorrentMetadataQuery orderByContainer($order = Criteria::ASC) Order by the container column
 * @method     ChildTorrentMetadataQuery orderByCrc32($order = Criteria::ASC) Order by the crc32 column
 * @method     ChildTorrentMetadataQuery orderByEp($order = Criteria::ASC) Order by the ep column
 * @method     ChildTorrentMetadataQuery orderByVolume($order = Criteria::ASC) Order by the volume column
 * @method     ChildTorrentMetadataQuery orderByCollection($order = Criteria::ASC) Order by the collection column
 * @method     ChildTorrentMetadataQuery orderByDateCreated($order = Criteria::ASC) Order by the date_created column
 * @method     ChildTorrentMetadataQuery orderByLastUpdated($order = Criteria::ASC) Order by the last_updated column
 *
 * @method     ChildTorrentMetadataQuery groupByTorrentId() Group by the torrent_id column
 * @method     ChildTorrentMetadataQuery groupByName() Group by the name column
 * @method     ChildTorrentMetadataQuery groupByType() Group by the type column
 * @method     ChildTorrentMetadataQuery groupByGroup() Group by the group column
 * @method     ChildTorrentMetadataQuery groupByUnparsed() Group by the unparsed column
 * @method     ChildTorrentMetadataQuery groupByResolution() Group by the resolution column
 * @method     ChildTorrentMetadataQuery groupByVideo() Group by the video column
 * @method     ChildTorrentMetadataQuery groupByVideoDepth() Group by the video_depth column
 * @method     ChildTorrentMetadataQuery groupByAudio() Group by the audio column
 * @method     ChildTorrentMetadataQuery groupBySource() Group by the source column
 * @method     ChildTorrentMetadataQuery groupByContainer() Group by the container column
 * @method     ChildTorrentMetadataQuery groupByCrc32() Group by the crc32 column
 * @method     ChildTorrentMetadataQuery groupByEp() Group by the ep column
 * @method     ChildTorrentMetadataQuery groupByVolume() Group by the volume column
 * @method     ChildTorrentMetadataQuery groupByCollection() Group by the collection column
 * @method     ChildTorrentMetadataQuery groupByDateCreated() Group by the date_created column
 * @method     ChildTorrentMetadataQuery groupByLastUpdated() Group by the last_updated column
 *
 * @method     ChildTorrentMetadataQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildTorrentMetadataQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildTorrentMetadataQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildTorrentMetadataQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildTorrentMetadataQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildTorrentMetadataQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildTorrentMetadataQuery leftJoinTorrent($relationAlias = null) Adds a LEFT JOIN clause to the query using the Torrent relation
 * @method     ChildTorrentMetadataQuery rightJoinTorrent($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Torrent relation
 * @method     ChildTorrentMetadataQuery innerJoinTorrent($relationAlias = null) Adds a INNER JOIN clause to the query using the Torrent relation
 *
 * @method     ChildTorrentMetadataQuery joinWithTorrent($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Torrent relation
 *
 * @method     ChildTorrentMetadataQuery leftJoinWithTorrent() Adds a LEFT JOIN clause and with to the query using the Torrent relation
 * @method     ChildTorrentMetadataQuery rightJoinWithTorrent() Adds a RIGHT JOIN clause and with to the query using the Torrent relation
 * @method     ChildTorrentMetadataQuery innerJoinWithTorrent() Adds a INNER JOIN clause and with to the query using the Torrent relation
 *
 * @method     \Odango\Hebi\Model\TorrentQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildTorrentMetadata findOne(ConnectionInterface $con = null) Return the first ChildTorrentMetadata matching the query
 * @method     ChildTorrentMetadata findOneOrCreate(ConnectionInterface $con = null) Return the first ChildTorrentMetadata matching the query, or a new ChildTorrentMetadata object populated from the query conditions when no match is found
 *
 * @method     ChildTorrentMetadata findOneByTorrentId(string $torrent_id) Return the first ChildTorrentMetadata filtered by the torrent_id column
 * @method     ChildTorrentMetadata findOneByName(string $name) Return the first ChildTorrentMetadata filtered by the name column
 * @method     ChildTorrentMetadata findOneByType(string $type) Return the first ChildTorrentMetadata filtered by the type column
 * @method     ChildTorrentMetadata findOneByGroup(string $group) Return the first ChildTorrentMetadata filtered by the group column
 * @method     ChildTorrentMetadata findOneByUnparsed(array $unparsed) Return the first ChildTorrentMetadata filtered by the unparsed column
 * @method     ChildTorrentMetadata findOneByResolution(string $resolution) Return the first ChildTorrentMetadata filtered by the resolution column
 * @method     ChildTorrentMetadata findOneByVideo(string $video) Return the first ChildTorrentMetadata filtered by the video column
 * @method     ChildTorrentMetadata findOneByVideoDepth(string $video_depth) Return the first ChildTorrentMetadata filtered by the video_depth column
 * @method     ChildTorrentMetadata findOneByAudio(string $audio) Return the first ChildTorrentMetadata filtered by the audio column
 * @method     ChildTorrentMetadata findOneBySource(string $source) Return the first ChildTorrentMetadata filtered by the source column
 * @method     ChildTorrentMetadata findOneByContainer(string $container) Return the first ChildTorrentMetadata filtered by the container column
 * @method     ChildTorrentMetadata findOneByCrc32(string $crc32) Return the first ChildTorrentMetadata filtered by the crc32 column
 * @method     ChildTorrentMetadata findOneByEp(string $ep) Return the first ChildTorrentMetadata filtered by the ep column
 * @method     ChildTorrentMetadata findOneByVolume(string $volume) Return the first ChildTorrentMetadata filtered by the volume column
 * @method     ChildTorrentMetadata findOneByCollection(array $collection) Return the first ChildTorrentMetadata filtered by the collection column
 * @method     ChildTorrentMetadata findOneByDateCreated(string $date_created) Return the first ChildTorrentMetadata filtered by the date_created column
 * @method     ChildTorrentMetadata findOneByLastUpdated(string $last_updated) Return the first ChildTorrentMetadata filtered by the last_updated column *

 * @method     ChildTorrentMetadata requirePk($key, ConnectionInterface $con = null) Return the ChildTorrentMetadata by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTorrentMetadata requireOne(ConnectionInterface $con = null) Return the first ChildTorrentMetadata matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildTorrentMetadata requireOneByTorrentId(string $torrent_id) Return the first ChildTorrentMetadata filtered by the torrent_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTorrentMetadata requireOneByName(string $name) Return the first ChildTorrentMetadata filtered by the name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTorrentMetadata requireOneByType(string $type) Return the first ChildTorrentMetadata filtered by the type column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTorrentMetadata requireOneByGroup(string $group) Return the first ChildTorrentMetadata filtered by the group column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTorrentMetadata requireOneByUnparsed(array $unparsed) Return the first ChildTorrentMetadata filtered by the unparsed column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTorrentMetadata requireOneByResolution(string $resolution) Return the first ChildTorrentMetadata filtered by the resolution column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTorrentMetadata requireOneByVideo(string $video) Return the first ChildTorrentMetadata filtered by the video column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTorrentMetadata requireOneByVideoDepth(string $video_depth) Return the first ChildTorrentMetadata filtered by the video_depth column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTorrentMetadata requireOneByAudio(string $audio) Return the first ChildTorrentMetadata filtered by the audio column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTorrentMetadata requireOneBySource(string $source) Return the first ChildTorrentMetadata filtered by the source column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTorrentMetadata requireOneByContainer(string $container) Return the first ChildTorrentMetadata filtered by the container column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTorrentMetadata requireOneByCrc32(string $crc32) Return the first ChildTorrentMetadata filtered by the crc32 column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTorrentMetadata requireOneByEp(string $ep) Return the first ChildTorrentMetadata filtered by the ep column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTorrentMetadata requireOneByVolume(string $volume) Return the first ChildTorrentMetadata filtered by the volume column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTorrentMetadata requireOneByCollection(array $collection) Return the first ChildTorrentMetadata filtered by the collection column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTorrentMetadata requireOneByDateCreated(string $date_created) Return the first ChildTorrentMetadata filtered by the date_created column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTorrentMetadata requireOneByLastUpdated(string $last_updated) Return the first ChildTorrentMetadata filtered by the last_updated column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildTorrentMetadata[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildTorrentMetadata objects based on current ModelCriteria
 * @method     ChildTorrentMetadata[]|ObjectCollection findByTorrentId(string $torrent_id) Return ChildTorrentMetadata objects filtered by the torrent_id column
 * @method     ChildTorrentMetadata[]|ObjectCollection findByName(string $name) Return ChildTorrentMetadata objects filtered by the name column
 * @method     ChildTorrentMetadata[]|ObjectCollection findByType(string $type) Return ChildTorrentMetadata objects filtered by the type column
 * @method     ChildTorrentMetadata[]|ObjectCollection findByGroup(string $group) Return ChildTorrentMetadata objects filtered by the group column
 * @method     ChildTorrentMetadata[]|ObjectCollection findByUnparsed(array $unparsed) Return ChildTorrentMetadata objects filtered by the unparsed column
 * @method     ChildTorrentMetadata[]|ObjectCollection findByResolution(string $resolution) Return ChildTorrentMetadata objects filtered by the resolution column
 * @method     ChildTorrentMetadata[]|ObjectCollection findByVideo(string $video) Return ChildTorrentMetadata objects filtered by the video column
 * @method     ChildTorrentMetadata[]|ObjectCollection findByVideoDepth(string $video_depth) Return ChildTorrentMetadata objects filtered by the video_depth column
 * @method     ChildTorrentMetadata[]|ObjectCollection findByAudio(string $audio) Return ChildTorrentMetadata objects filtered by the audio column
 * @method     ChildTorrentMetadata[]|ObjectCollection findBySource(string $source) Return ChildTorrentMetadata objects filtered by the source column
 * @method     ChildTorrentMetadata[]|ObjectCollection findByContainer(string $container) Return ChildTorrentMetadata objects filtered by the container column
 * @method     ChildTorrentMetadata[]|ObjectCollection findByCrc32(string $crc32) Return ChildTorrentMetadata objects filtered by the crc32 column
 * @method     ChildTorrentMetadata[]|ObjectCollection findByEp(string $ep) Return ChildTorrentMetadata objects filtered by the ep column
 * @method     ChildTorrentMetadata[]|ObjectCollection findByVolume(string $volume) Return ChildTorrentMetadata objects filtered by the volume column
 * @method     ChildTorrentMetadata[]|ObjectCollection findByCollection(array $collection) Return ChildTorrentMetadata objects filtered by the collection column
 * @method     ChildTorrentMetadata[]|ObjectCollection findByDateCreated(string $date_created) Return ChildTorrentMetadata objects filtered by the date_created column
 * @method     ChildTorrentMetadata[]|ObjectCollection findByLastUpdated(string $last_updated) Return ChildTorrentMetadata objects filtered by the last_updated column
 * @method     ChildTorrentMetadata[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class TorrentMetadataQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Odango\Hebi\Model\Base\TorrentMetadataQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Odango\\Hebi\\Model\\TorrentMetadata', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildTorrentMetadataQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildTorrentMetadataQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildTorrentMetadataQuery) {
            return $criteria;
        }
        $query = new ChildTorrentMetadataQuery();
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
     * @return ChildTorrentMetadata|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(TorrentMetadataTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = TorrentMetadataTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildTorrentMetadata A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT `torrent_id`, `name`, `type`, `group`, `unparsed`, `resolution`, `video`, `video_depth`, `audio`, `source`, `container`, `crc32`, `ep`, `volume`, `collection`, `date_created`, `last_updated` FROM `torrent_metadata` WHERE `torrent_id` = :p0';
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
            /** @var ChildTorrentMetadata $obj */
            $obj = new ChildTorrentMetadata();
            $obj->hydrate($row);
            TorrentMetadataTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildTorrentMetadata|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildTorrentMetadataQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(TorrentMetadataTableMap::COL_TORRENT_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildTorrentMetadataQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(TorrentMetadataTableMap::COL_TORRENT_ID, $keys, Criteria::IN);
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
     * @return $this|ChildTorrentMetadataQuery The current query, for fluid interface
     */
    public function filterByTorrentId($torrentId = null, $comparison = null)
    {
        if (is_array($torrentId)) {
            $useMinMax = false;
            if (isset($torrentId['min'])) {
                $this->addUsingAlias(TorrentMetadataTableMap::COL_TORRENT_ID, $torrentId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($torrentId['max'])) {
                $this->addUsingAlias(TorrentMetadataTableMap::COL_TORRENT_ID, $torrentId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TorrentMetadataTableMap::COL_TORRENT_ID, $torrentId, $comparison);
    }

    /**
     * Filter the query on the name column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue');   // WHERE name = 'fooValue'
     * $query->filterByName('%fooValue%', Criteria::LIKE); // WHERE name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $name The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTorrentMetadataQuery The current query, for fluid interface
     */
    public function filterByName($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TorrentMetadataTableMap::COL_NAME, $name, $comparison);
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
     * @return $this|ChildTorrentMetadataQuery The current query, for fluid interface
     */
    public function filterByType($type = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($type)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TorrentMetadataTableMap::COL_TYPE, $type, $comparison);
    }

    /**
     * Filter the query on the group column
     *
     * Example usage:
     * <code>
     * $query->filterByGroup('fooValue');   // WHERE group = 'fooValue'
     * $query->filterByGroup('%fooValue%', Criteria::LIKE); // WHERE group LIKE '%fooValue%'
     * </code>
     *
     * @param     string $group The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTorrentMetadataQuery The current query, for fluid interface
     */
    public function filterByGroup($group = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($group)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TorrentMetadataTableMap::COL_GROUP, $group, $comparison);
    }

    /**
     * Filter the query on the unparsed column
     *
     * @param     array $unparsed The values to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTorrentMetadataQuery The current query, for fluid interface
     */
    public function filterByUnparsed($unparsed = null, $comparison = null)
    {
        $key = $this->getAliasedColName(TorrentMetadataTableMap::COL_UNPARSED);
        if (null === $comparison || $comparison == Criteria::CONTAINS_ALL) {
            foreach ($unparsed as $value) {
                $value = '%| ' . $value . ' |%';
                if ($this->containsKey($key)) {
                    $this->addAnd($key, $value, Criteria::LIKE);
                } else {
                    $this->add($key, $value, Criteria::LIKE);
                }
            }

            return $this;
        } elseif ($comparison == Criteria::CONTAINS_SOME) {
            foreach ($unparsed as $value) {
                $value = '%| ' . $value . ' |%';
                if ($this->containsKey($key)) {
                    $this->addOr($key, $value, Criteria::LIKE);
                } else {
                    $this->add($key, $value, Criteria::LIKE);
                }
            }

            return $this;
        } elseif ($comparison == Criteria::CONTAINS_NONE) {
            foreach ($unparsed as $value) {
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

        return $this->addUsingAlias(TorrentMetadataTableMap::COL_UNPARSED, $unparsed, $comparison);
    }

    /**
     * Filter the query on the resolution column
     *
     * Example usage:
     * <code>
     * $query->filterByResolution('fooValue');   // WHERE resolution = 'fooValue'
     * $query->filterByResolution('%fooValue%', Criteria::LIKE); // WHERE resolution LIKE '%fooValue%'
     * </code>
     *
     * @param     string $resolution The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTorrentMetadataQuery The current query, for fluid interface
     */
    public function filterByResolution($resolution = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($resolution)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TorrentMetadataTableMap::COL_RESOLUTION, $resolution, $comparison);
    }

    /**
     * Filter the query on the video column
     *
     * Example usage:
     * <code>
     * $query->filterByVideo('fooValue');   // WHERE video = 'fooValue'
     * $query->filterByVideo('%fooValue%', Criteria::LIKE); // WHERE video LIKE '%fooValue%'
     * </code>
     *
     * @param     string $video The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTorrentMetadataQuery The current query, for fluid interface
     */
    public function filterByVideo($video = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($video)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TorrentMetadataTableMap::COL_VIDEO, $video, $comparison);
    }

    /**
     * Filter the query on the video_depth column
     *
     * Example usage:
     * <code>
     * $query->filterByVideoDepth('fooValue');   // WHERE video_depth = 'fooValue'
     * $query->filterByVideoDepth('%fooValue%', Criteria::LIKE); // WHERE video_depth LIKE '%fooValue%'
     * </code>
     *
     * @param     string $videoDepth The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTorrentMetadataQuery The current query, for fluid interface
     */
    public function filterByVideoDepth($videoDepth = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($videoDepth)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TorrentMetadataTableMap::COL_VIDEO_DEPTH, $videoDepth, $comparison);
    }

    /**
     * Filter the query on the audio column
     *
     * Example usage:
     * <code>
     * $query->filterByAudio('fooValue');   // WHERE audio = 'fooValue'
     * $query->filterByAudio('%fooValue%', Criteria::LIKE); // WHERE audio LIKE '%fooValue%'
     * </code>
     *
     * @param     string $audio The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTorrentMetadataQuery The current query, for fluid interface
     */
    public function filterByAudio($audio = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($audio)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TorrentMetadataTableMap::COL_AUDIO, $audio, $comparison);
    }

    /**
     * Filter the query on the source column
     *
     * Example usage:
     * <code>
     * $query->filterBySource('fooValue');   // WHERE source = 'fooValue'
     * $query->filterBySource('%fooValue%', Criteria::LIKE); // WHERE source LIKE '%fooValue%'
     * </code>
     *
     * @param     string $source The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTorrentMetadataQuery The current query, for fluid interface
     */
    public function filterBySource($source = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($source)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TorrentMetadataTableMap::COL_SOURCE, $source, $comparison);
    }

    /**
     * Filter the query on the container column
     *
     * Example usage:
     * <code>
     * $query->filterByContainer('fooValue');   // WHERE container = 'fooValue'
     * $query->filterByContainer('%fooValue%', Criteria::LIKE); // WHERE container LIKE '%fooValue%'
     * </code>
     *
     * @param     string $container The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTorrentMetadataQuery The current query, for fluid interface
     */
    public function filterByContainer($container = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($container)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TorrentMetadataTableMap::COL_CONTAINER, $container, $comparison);
    }

    /**
     * Filter the query on the crc32 column
     *
     * Example usage:
     * <code>
     * $query->filterByCrc32('fooValue');   // WHERE crc32 = 'fooValue'
     * $query->filterByCrc32('%fooValue%', Criteria::LIKE); // WHERE crc32 LIKE '%fooValue%'
     * </code>
     *
     * @param     string $crc32 The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTorrentMetadataQuery The current query, for fluid interface
     */
    public function filterByCrc32($crc32 = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($crc32)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TorrentMetadataTableMap::COL_CRC32, $crc32, $comparison);
    }

    /**
     * Filter the query on the ep column
     *
     * Example usage:
     * <code>
     * $query->filterByEp('fooValue');   // WHERE ep = 'fooValue'
     * $query->filterByEp('%fooValue%', Criteria::LIKE); // WHERE ep LIKE '%fooValue%'
     * </code>
     *
     * @param     string $ep The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTorrentMetadataQuery The current query, for fluid interface
     */
    public function filterByEp($ep = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($ep)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TorrentMetadataTableMap::COL_EP, $ep, $comparison);
    }

    /**
     * Filter the query on the volume column
     *
     * Example usage:
     * <code>
     * $query->filterByVolume('fooValue');   // WHERE volume = 'fooValue'
     * $query->filterByVolume('%fooValue%', Criteria::LIKE); // WHERE volume LIKE '%fooValue%'
     * </code>
     *
     * @param     string $volume The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTorrentMetadataQuery The current query, for fluid interface
     */
    public function filterByVolume($volume = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($volume)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TorrentMetadataTableMap::COL_VOLUME, $volume, $comparison);
    }

    /**
     * Filter the query on the collection column
     *
     * @param     array $collection The values to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTorrentMetadataQuery The current query, for fluid interface
     */
    public function filterByCollection($collection = null, $comparison = null)
    {
        $key = $this->getAliasedColName(TorrentMetadataTableMap::COL_COLLECTION);
        if (null === $comparison || $comparison == Criteria::CONTAINS_ALL) {
            foreach ($collection as $value) {
                $value = '%| ' . $value . ' |%';
                if ($this->containsKey($key)) {
                    $this->addAnd($key, $value, Criteria::LIKE);
                } else {
                    $this->add($key, $value, Criteria::LIKE);
                }
            }

            return $this;
        } elseif ($comparison == Criteria::CONTAINS_SOME) {
            foreach ($collection as $value) {
                $value = '%| ' . $value . ' |%';
                if ($this->containsKey($key)) {
                    $this->addOr($key, $value, Criteria::LIKE);
                } else {
                    $this->add($key, $value, Criteria::LIKE);
                }
            }

            return $this;
        } elseif ($comparison == Criteria::CONTAINS_NONE) {
            foreach ($collection as $value) {
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

        return $this->addUsingAlias(TorrentMetadataTableMap::COL_COLLECTION, $collection, $comparison);
    }

    /**
     * Filter the query on the date_created column
     *
     * Example usage:
     * <code>
     * $query->filterByDateCreated('2011-03-14'); // WHERE date_created = '2011-03-14'
     * $query->filterByDateCreated('now'); // WHERE date_created = '2011-03-14'
     * $query->filterByDateCreated(array('max' => 'yesterday')); // WHERE date_created > '2011-03-13'
     * </code>
     *
     * @param     mixed $dateCreated The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTorrentMetadataQuery The current query, for fluid interface
     */
    public function filterByDateCreated($dateCreated = null, $comparison = null)
    {
        if (is_array($dateCreated)) {
            $useMinMax = false;
            if (isset($dateCreated['min'])) {
                $this->addUsingAlias(TorrentMetadataTableMap::COL_DATE_CREATED, $dateCreated['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dateCreated['max'])) {
                $this->addUsingAlias(TorrentMetadataTableMap::COL_DATE_CREATED, $dateCreated['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TorrentMetadataTableMap::COL_DATE_CREATED, $dateCreated, $comparison);
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
     * @return $this|ChildTorrentMetadataQuery The current query, for fluid interface
     */
    public function filterByLastUpdated($lastUpdated = null, $comparison = null)
    {
        if (is_array($lastUpdated)) {
            $useMinMax = false;
            if (isset($lastUpdated['min'])) {
                $this->addUsingAlias(TorrentMetadataTableMap::COL_LAST_UPDATED, $lastUpdated['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($lastUpdated['max'])) {
                $this->addUsingAlias(TorrentMetadataTableMap::COL_LAST_UPDATED, $lastUpdated['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TorrentMetadataTableMap::COL_LAST_UPDATED, $lastUpdated, $comparison);
    }

    /**
     * Filter the query by a related \Odango\Hebi\Model\Torrent object
     *
     * @param \Odango\Hebi\Model\Torrent|ObjectCollection $torrent The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildTorrentMetadataQuery The current query, for fluid interface
     */
    public function filterByTorrent($torrent, $comparison = null)
    {
        if ($torrent instanceof \Odango\Hebi\Model\Torrent) {
            return $this
                ->addUsingAlias(TorrentMetadataTableMap::COL_TORRENT_ID, $torrent->getId(), $comparison);
        } elseif ($torrent instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(TorrentMetadataTableMap::COL_TORRENT_ID, $torrent->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildTorrentMetadataQuery The current query, for fluid interface
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
     * @param   ChildTorrentMetadata $torrentMetadata Object to remove from the list of results
     *
     * @return $this|ChildTorrentMetadataQuery The current query, for fluid interface
     */
    public function prune($torrentMetadata = null)
    {
        if ($torrentMetadata) {
            $this->addUsingAlias(TorrentMetadataTableMap::COL_TORRENT_ID, $torrentMetadata->getTorrentId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the torrent_metadata table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(TorrentMetadataTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            TorrentMetadataTableMap::clearInstancePool();
            TorrentMetadataTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(TorrentMetadataTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(TorrentMetadataTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            TorrentMetadataTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            TorrentMetadataTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     $this|ChildTorrentMetadataQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(TorrentMetadataTableMap::COL_LAST_UPDATED, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     $this|ChildTorrentMetadataQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(TorrentMetadataTableMap::COL_LAST_UPDATED);
    }

    /**
     * Order by update date asc
     *
     * @return     $this|ChildTorrentMetadataQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(TorrentMetadataTableMap::COL_LAST_UPDATED);
    }

    /**
     * Order by create date desc
     *
     * @return     $this|ChildTorrentMetadataQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(TorrentMetadataTableMap::COL_DATE_CREATED);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     $this|ChildTorrentMetadataQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(TorrentMetadataTableMap::COL_DATE_CREATED, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by create date asc
     *
     * @return     $this|ChildTorrentMetadataQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(TorrentMetadataTableMap::COL_DATE_CREATED);
    }

} // TorrentMetadataQuery
