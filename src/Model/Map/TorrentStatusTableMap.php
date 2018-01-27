<?php

namespace Odango\Hebi\Model\Map;

use Odango\Hebi\Model\TorrentStatus;
use Odango\Hebi\Model\TorrentStatusQuery;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;


/**
 * This class defines the structure of the 'torrent_status' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class TorrentStatusTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.TorrentStatusTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'torrent_status';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Odango\\Hebi\\Model\\TorrentStatus';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'TorrentStatus';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 8;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 8;

    /**
     * the column name for the torrent_id field
     */
    const COL_TORRENT_ID = 'torrent_status.torrent_id';

    /**
     * the column name for the success field
     */
    const COL_SUCCESS = 'torrent_status.success';

    /**
     * the column name for the tracker field
     */
    const COL_TRACKER = 'torrent_status.tracker';

    /**
     * the column name for the seeders field
     */
    const COL_SEEDERS = 'torrent_status.seeders';

    /**
     * the column name for the leechers field
     */
    const COL_LEECHERS = 'torrent_status.leechers';

    /**
     * the column name for the downloaded field
     */
    const COL_DOWNLOADED = 'torrent_status.downloaded';

    /**
     * the column name for the last_updated field
     */
    const COL_LAST_UPDATED = 'torrent_status.last_updated';

    /**
     * the column name for the created_at field
     */
    const COL_CREATED_AT = 'torrent_status.created_at';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('TorrentId', 'Success', 'Tracker', 'Seeders', 'Leechers', 'Downloaded', 'LastUpdated', 'CreatedAt', ),
        self::TYPE_CAMELNAME     => array('torrentId', 'success', 'tracker', 'seeders', 'leechers', 'downloaded', 'lastUpdated', 'createdAt', ),
        self::TYPE_COLNAME       => array(TorrentStatusTableMap::COL_TORRENT_ID, TorrentStatusTableMap::COL_SUCCESS, TorrentStatusTableMap::COL_TRACKER, TorrentStatusTableMap::COL_SEEDERS, TorrentStatusTableMap::COL_LEECHERS, TorrentStatusTableMap::COL_DOWNLOADED, TorrentStatusTableMap::COL_LAST_UPDATED, TorrentStatusTableMap::COL_CREATED_AT, ),
        self::TYPE_FIELDNAME     => array('torrent_id', 'success', 'tracker', 'seeders', 'leechers', 'downloaded', 'last_updated', 'created_at', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('TorrentId' => 0, 'Success' => 1, 'Tracker' => 2, 'Seeders' => 3, 'Leechers' => 4, 'Downloaded' => 5, 'LastUpdated' => 6, 'CreatedAt' => 7, ),
        self::TYPE_CAMELNAME     => array('torrentId' => 0, 'success' => 1, 'tracker' => 2, 'seeders' => 3, 'leechers' => 4, 'downloaded' => 5, 'lastUpdated' => 6, 'createdAt' => 7, ),
        self::TYPE_COLNAME       => array(TorrentStatusTableMap::COL_TORRENT_ID => 0, TorrentStatusTableMap::COL_SUCCESS => 1, TorrentStatusTableMap::COL_TRACKER => 2, TorrentStatusTableMap::COL_SEEDERS => 3, TorrentStatusTableMap::COL_LEECHERS => 4, TorrentStatusTableMap::COL_DOWNLOADED => 5, TorrentStatusTableMap::COL_LAST_UPDATED => 6, TorrentStatusTableMap::COL_CREATED_AT => 7, ),
        self::TYPE_FIELDNAME     => array('torrent_id' => 0, 'success' => 1, 'tracker' => 2, 'seeders' => 3, 'leechers' => 4, 'downloaded' => 5, 'last_updated' => 6, 'created_at' => 7, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, )
    );

    /**
     * Initialize the table attributes and columns
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('torrent_status');
        $this->setPhpName('TorrentStatus');
        $this->setIdentifierQuoting(true);
        $this->setClassName('\\Odango\\Hebi\\Model\\TorrentStatus');
        $this->setPackage('');
        $this->setUseIdGenerator(false);
        // columns
        $this->addForeignPrimaryKey('torrent_id', 'TorrentId', 'BIGINT' , 'torrent', 'id', true, null, null);
        $this->addColumn('success', 'Success', 'BOOLEAN', false, 1, true);
        $this->addColumn('tracker', 'Tracker', 'VARCHAR', false, 255, null);
        $this->addColumn('seeders', 'Seeders', 'BIGINT', false, null, null);
        $this->addColumn('leechers', 'Leechers', 'BIGINT', false, null, null);
        $this->addColumn('downloaded', 'Downloaded', 'BIGINT', false, null, null);
        $this->addColumn('last_updated', 'LastUpdated', 'TIMESTAMP', false, null, null);
        $this->addColumn('created_at', 'CreatedAt', 'TIMESTAMP', false, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Torrent', '\\Odango\\Hebi\\Model\\Torrent', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':torrent_id',
    1 => ':id',
  ),
), null, null, null, false);
    } // buildRelations()

    /**
     *
     * Gets the list of behaviors registered for this table
     *
     * @return array Associative array (name => parameters) of behaviors
     */
    public function getBehaviors()
    {
        return array(
            'timestampable' => array('create_column' => 'created_at', 'update_column' => 'last_updated', 'disable_created_at' => 'false', 'disable_updated_at' => 'false', ),
        );
    } // getBehaviors()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return string The primary key hash of the row
     */
    public static function getPrimaryKeyHashFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        // If the PK cannot be derived from the row, return NULL.
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('TorrentId', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return null === $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('TorrentId', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('TorrentId', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('TorrentId', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('TorrentId', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('TorrentId', TableMap::TYPE_PHPNAME, $indexType)];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        return (string) $row[
            $indexType == TableMap::TYPE_NUM
                ? 0 + $offset
                : self::translateFieldName('TorrentId', TableMap::TYPE_PHPNAME, $indexType)
        ];
    }

    /**
     * The class that the tableMap will make instances of.
     *
     * If $withPrefix is true, the returned path
     * uses a dot-path notation which is translated into a path
     * relative to a location on the PHP include_path.
     * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
     *
     * @param boolean $withPrefix Whether or not to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass($withPrefix = true)
    {
        return $withPrefix ? TorrentStatusTableMap::CLASS_DEFAULT : TorrentStatusTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array  $row       row returned by DataFetcher->fetch().
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     * @return array           (TorrentStatus object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = TorrentStatusTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = TorrentStatusTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + TorrentStatusTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = TorrentStatusTableMap::OM_CLASS;
            /** @var TorrentStatus $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            TorrentStatusTableMap::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param DataFetcherInterface $dataFetcher
     * @return array
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher)
    {
        $results = array();

        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = TorrentStatusTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = TorrentStatusTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var TorrentStatus $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                TorrentStatusTableMap::addInstanceToPool($obj, $key);
            } // if key exists
        }

        return $results;
    }
    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param Criteria $criteria object containing the columns to add.
     * @param string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(TorrentStatusTableMap::COL_TORRENT_ID);
            $criteria->addSelectColumn(TorrentStatusTableMap::COL_SUCCESS);
            $criteria->addSelectColumn(TorrentStatusTableMap::COL_TRACKER);
            $criteria->addSelectColumn(TorrentStatusTableMap::COL_SEEDERS);
            $criteria->addSelectColumn(TorrentStatusTableMap::COL_LEECHERS);
            $criteria->addSelectColumn(TorrentStatusTableMap::COL_DOWNLOADED);
            $criteria->addSelectColumn(TorrentStatusTableMap::COL_LAST_UPDATED);
            $criteria->addSelectColumn(TorrentStatusTableMap::COL_CREATED_AT);
        } else {
            $criteria->addSelectColumn($alias . '.torrent_id');
            $criteria->addSelectColumn($alias . '.success');
            $criteria->addSelectColumn($alias . '.tracker');
            $criteria->addSelectColumn($alias . '.seeders');
            $criteria->addSelectColumn($alias . '.leechers');
            $criteria->addSelectColumn($alias . '.downloaded');
            $criteria->addSelectColumn($alias . '.last_updated');
            $criteria->addSelectColumn($alias . '.created_at');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getServiceContainer()->getDatabaseMap(TorrentStatusTableMap::DATABASE_NAME)->getTable(TorrentStatusTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(TorrentStatusTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(TorrentStatusTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new TorrentStatusTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a TorrentStatus or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or TorrentStatus object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param  ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(TorrentStatusTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Odango\Hebi\Model\TorrentStatus) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(TorrentStatusTableMap::DATABASE_NAME);
            $criteria->add(TorrentStatusTableMap::COL_TORRENT_ID, (array) $values, Criteria::IN);
        }

        $query = TorrentStatusQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            TorrentStatusTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                TorrentStatusTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the torrent_status table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return TorrentStatusQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a TorrentStatus or Criteria object.
     *
     * @param mixed               $criteria Criteria or TorrentStatus object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(TorrentStatusTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from TorrentStatus object
        }


        // Set the correct dbName
        $query = TorrentStatusQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // TorrentStatusTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
TorrentStatusTableMap::buildTableMap();
