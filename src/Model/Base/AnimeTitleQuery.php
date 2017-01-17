<?php

namespace Odango\Hebi\Model\Base;

use \Exception;
use \PDO;
use Odango\Hebi\Model\AnimeTitle as ChildAnimeTitle;
use Odango\Hebi\Model\AnimeTitleQuery as ChildAnimeTitleQuery;
use Odango\Hebi\Model\Map\AnimeTitleTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'anime_title' table.
 *
 *
 *
 * @method     ChildAnimeTitleQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildAnimeTitleQuery orderByAnimeId($order = Criteria::ASC) Order by the anime_id column
 * @method     ChildAnimeTitleQuery orderByMain($order = Criteria::ASC) Order by the main column
 * @method     ChildAnimeTitleQuery orderByName($order = Criteria::ASC) Order by the name column
 *
 * @method     ChildAnimeTitleQuery groupById() Group by the id column
 * @method     ChildAnimeTitleQuery groupByAnimeId() Group by the anime_id column
 * @method     ChildAnimeTitleQuery groupByMain() Group by the main column
 * @method     ChildAnimeTitleQuery groupByName() Group by the name column
 *
 * @method     ChildAnimeTitleQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildAnimeTitleQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildAnimeTitleQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildAnimeTitleQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildAnimeTitleQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildAnimeTitleQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildAnimeTitle findOne(ConnectionInterface $con = null) Return the first ChildAnimeTitle matching the query
 * @method     ChildAnimeTitle findOneOrCreate(ConnectionInterface $con = null) Return the first ChildAnimeTitle matching the query, or a new ChildAnimeTitle object populated from the query conditions when no match is found
 *
 * @method     ChildAnimeTitle findOneById(string $id) Return the first ChildAnimeTitle filtered by the id column
 * @method     ChildAnimeTitle findOneByAnimeId(string $anime_id) Return the first ChildAnimeTitle filtered by the anime_id column
 * @method     ChildAnimeTitle findOneByMain(boolean $main) Return the first ChildAnimeTitle filtered by the main column
 * @method     ChildAnimeTitle findOneByName(string $name) Return the first ChildAnimeTitle filtered by the name column *

 * @method     ChildAnimeTitle requirePk($key, ConnectionInterface $con = null) Return the ChildAnimeTitle by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAnimeTitle requireOne(ConnectionInterface $con = null) Return the first ChildAnimeTitle matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildAnimeTitle requireOneById(string $id) Return the first ChildAnimeTitle filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAnimeTitle requireOneByAnimeId(string $anime_id) Return the first ChildAnimeTitle filtered by the anime_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAnimeTitle requireOneByMain(boolean $main) Return the first ChildAnimeTitle filtered by the main column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAnimeTitle requireOneByName(string $name) Return the first ChildAnimeTitle filtered by the name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildAnimeTitle[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildAnimeTitle objects based on current ModelCriteria
 * @method     ChildAnimeTitle[]|ObjectCollection findById(string $id) Return ChildAnimeTitle objects filtered by the id column
 * @method     ChildAnimeTitle[]|ObjectCollection findByAnimeId(string $anime_id) Return ChildAnimeTitle objects filtered by the anime_id column
 * @method     ChildAnimeTitle[]|ObjectCollection findByMain(boolean $main) Return ChildAnimeTitle objects filtered by the main column
 * @method     ChildAnimeTitle[]|ObjectCollection findByName(string $name) Return ChildAnimeTitle objects filtered by the name column
 * @method     ChildAnimeTitle[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class AnimeTitleQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Odango\Hebi\Model\Base\AnimeTitleQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Odango\\Hebi\\Model\\AnimeTitle', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildAnimeTitleQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildAnimeTitleQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildAnimeTitleQuery) {
            return $criteria;
        }
        $query = new ChildAnimeTitleQuery();
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
     * @return ChildAnimeTitle|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(AnimeTitleTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = AnimeTitleTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildAnimeTitle A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT `id`, `anime_id`, `main`, `name` FROM `anime_title` WHERE `id` = :p0';
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
            /** @var ChildAnimeTitle $obj */
            $obj = new ChildAnimeTitle();
            $obj->hydrate($row);
            AnimeTitleTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildAnimeTitle|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildAnimeTitleQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(AnimeTitleTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildAnimeTitleQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(AnimeTitleTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildAnimeTitleQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(AnimeTitleTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(AnimeTitleTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AnimeTitleTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the anime_id column
     *
     * Example usage:
     * <code>
     * $query->filterByAnimeId(1234); // WHERE anime_id = 1234
     * $query->filterByAnimeId(array(12, 34)); // WHERE anime_id IN (12, 34)
     * $query->filterByAnimeId(array('min' => 12)); // WHERE anime_id > 12
     * </code>
     *
     * @param     mixed $animeId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAnimeTitleQuery The current query, for fluid interface
     */
    public function filterByAnimeId($animeId = null, $comparison = null)
    {
        if (is_array($animeId)) {
            $useMinMax = false;
            if (isset($animeId['min'])) {
                $this->addUsingAlias(AnimeTitleTableMap::COL_ANIME_ID, $animeId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($animeId['max'])) {
                $this->addUsingAlias(AnimeTitleTableMap::COL_ANIME_ID, $animeId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AnimeTitleTableMap::COL_ANIME_ID, $animeId, $comparison);
    }

    /**
     * Filter the query on the main column
     *
     * Example usage:
     * <code>
     * $query->filterByMain(true); // WHERE main = true
     * $query->filterByMain('yes'); // WHERE main = true
     * </code>
     *
     * @param     boolean|string $main The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAnimeTitleQuery The current query, for fluid interface
     */
    public function filterByMain($main = null, $comparison = null)
    {
        if (is_string($main)) {
            $main = in_array(strtolower($main), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(AnimeTitleTableMap::COL_MAIN, $main, $comparison);
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
     * @return $this|ChildAnimeTitleQuery The current query, for fluid interface
     */
    public function filterByName($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AnimeTitleTableMap::COL_NAME, $name, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildAnimeTitle $animeTitle Object to remove from the list of results
     *
     * @return $this|ChildAnimeTitleQuery The current query, for fluid interface
     */
    public function prune($animeTitle = null)
    {
        if ($animeTitle) {
            $this->addUsingAlias(AnimeTitleTableMap::COL_ID, $animeTitle->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the anime_title table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(AnimeTitleTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            AnimeTitleTableMap::clearInstancePool();
            AnimeTitleTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(AnimeTitleTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(AnimeTitleTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            AnimeTitleTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            AnimeTitleTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // AnimeTitleQuery
