<?php

namespace Odango\Hebi\Model\Map;

use Odango\Hebi\Model\Torrent;
use Odango\Hebi\Model\TorrentQuery;
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
 * This class defines the structure of the 'torrent' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class TorrentTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.TorrentTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'torrent';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Odango\\Hebi\\Model\\Torrent';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Torrent';

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
     * the column name for the id field
     */
    const COL_ID = 'torrent.id';

    /**
     * the column name for the info_hash field
     */
    const COL_INFO_HASH = 'torrent.info_hash';

    /**
     * the column name for the cached_torrent_file field
     */
    const COL_CACHED_TORRENT_FILE = 'torrent.cached_torrent_file';

    /**
     * the column name for the torrent_title field
     */
    const COL_TORRENT_TITLE = 'torrent.torrent_title';

    /**
     * the column name for the submitter_id field
     */
    const COL_SUBMITTER_ID = 'torrent.submitter_id';

    /**
     * the column name for the trackers field
     */
    const COL_TRACKERS = 'torrent.trackers';

    /**
     * the column name for the date_crawled field
     */
    const COL_DATE_CRAWLED = 'torrent.date_crawled';

    /**
     * the column name for the last_updated field
     */
    const COL_LAST_UPDATED = 'torrent.last_updated';

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
        self::TYPE_PHPNAME       => array('Id', 'InfoHash', 'CachedTorrentFile', 'TorrentTitle', 'SubmitterId', 'Trackers', 'DateCrawled', 'LastUpdated', ),
        self::TYPE_CAMELNAME     => array('id', 'infoHash', 'cachedTorrentFile', 'torrentTitle', 'submitterId', 'trackers', 'dateCrawled', 'lastUpdated', ),
        self::TYPE_COLNAME       => array(TorrentTableMap::COL_ID, TorrentTableMap::COL_INFO_HASH, TorrentTableMap::COL_CACHED_TORRENT_FILE, TorrentTableMap::COL_TORRENT_TITLE, TorrentTableMap::COL_SUBMITTER_ID, TorrentTableMap::COL_TRACKERS, TorrentTableMap::COL_DATE_CRAWLED, TorrentTableMap::COL_LAST_UPDATED, ),
        self::TYPE_FIELDNAME     => array('id', 'info_hash', 'cached_torrent_file', 'torrent_title', 'submitter_id', 'trackers', 'date_crawled', 'last_updated', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'InfoHash' => 1, 'CachedTorrentFile' => 2, 'TorrentTitle' => 3, 'SubmitterId' => 4, 'Trackers' => 5, 'DateCrawled' => 6, 'LastUpdated' => 7, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'infoHash' => 1, 'cachedTorrentFile' => 2, 'torrentTitle' => 3, 'submitterId' => 4, 'trackers' => 5, 'dateCrawled' => 6, 'lastUpdated' => 7, ),
        self::TYPE_COLNAME       => array(TorrentTableMap::COL_ID => 0, TorrentTableMap::COL_INFO_HASH => 1, TorrentTableMap::COL_CACHED_TORRENT_FILE => 2, TorrentTableMap::COL_TORRENT_TITLE => 3, TorrentTableMap::COL_SUBMITTER_ID => 4, TorrentTableMap::COL_TRACKERS => 5, TorrentTableMap::COL_DATE_CRAWLED => 6, TorrentTableMap::COL_LAST_UPDATED => 7, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'info_hash' => 1, 'cached_torrent_file' => 2, 'torrent_title' => 3, 'submitter_id' => 4, 'trackers' => 5, 'date_crawled' => 6, 'last_updated' => 7, ),
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
        $this->setName('torrent');
        $this->setPhpName('Torrent');
        $this->setIdentifierQuoting(true);
        $this->setClassName('\\Odango\\Hebi\\Model\\Torrent');
        $this->setPackage('');
        $this->setUseIdGenerator(false);
        // columns
        $this->addPrimaryKey('id', 'Id', 'BIGINT', true, null, null);
        $this->addColumn('info_hash', 'InfoHash', 'VARCHAR', true, 40, null);
        $this->addColumn('cached_torrent_file', 'CachedTorrentFile', 'LONGVARCHAR', false, null, null);
        $this->addColumn('torrent_title', 'TorrentTitle', 'LONGVARCHAR', false, null, null);
        $this->addColumn('submitter_id', 'SubmitterId', 'BIGINT', false, null, null);
        $this->addColumn('trackers', 'Trackers', 'ARRAY', false, null, null);
        $this->addColumn('date_crawled', 'DateCrawled', 'TIMESTAMP', false, null, null);
        $this->addColumn('last_updated', 'LastUpdated', 'TIMESTAMP', false, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('TorrentStatus', '\\Odango\\Hebi\\Model\\TorrentStatus', RelationMap::ONE_TO_ONE, array (
  0 =>
  array (
    0 => ':torrent_id',
    1 => ':id',
  ),
), null, null, null, false);
        $this->addRelation('TorrentMetadata', '\\Odango\\Hebi\\Model\\TorrentMetadata', RelationMap::ONE_TO_ONE, array (
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
            'timestampable' => array('create_column' => 'date_crawled', 'update_column' => 'last_updated', 'disable_created_at' => 'false', 'disable_updated_at' => 'false', ),
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return null === $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
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
                : self::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)
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
        return $withPrefix ? TorrentTableMap::CLASS_DEFAULT : TorrentTableMap::OM_CLASS;
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
     * @return array           (Torrent object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = TorrentTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = TorrentTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + TorrentTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = TorrentTableMap::OM_CLASS;
            /** @var Torrent $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            TorrentTableMap::addInstanceToPool($obj, $key);
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
            $key = TorrentTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = TorrentTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Torrent $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                TorrentTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(TorrentTableMap::COL_ID);
            $criteria->addSelectColumn(TorrentTableMap::COL_INFO_HASH);
            $criteria->addSelectColumn(TorrentTableMap::COL_CACHED_TORRENT_FILE);
            $criteria->addSelectColumn(TorrentTableMap::COL_TORRENT_TITLE);
            $criteria->addSelectColumn(TorrentTableMap::COL_SUBMITTER_ID);
            $criteria->addSelectColumn(TorrentTableMap::COL_TRACKERS);
            $criteria->addSelectColumn(TorrentTableMap::COL_DATE_CRAWLED);
            $criteria->addSelectColumn(TorrentTableMap::COL_LAST_UPDATED);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.info_hash');
            $criteria->addSelectColumn($alias . '.cached_torrent_file');
            $criteria->addSelectColumn($alias . '.torrent_title');
            $criteria->addSelectColumn($alias . '.submitter_id');
            $criteria->addSelectColumn($alias . '.trackers');
            $criteria->addSelectColumn($alias . '.date_crawled');
            $criteria->addSelectColumn($alias . '.last_updated');
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
        return Propel::getServiceContainer()->getDatabaseMap(TorrentTableMap::DATABASE_NAME)->getTable(TorrentTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(TorrentTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(TorrentTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new TorrentTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Torrent or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Torrent object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(TorrentTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Odango\Hebi\Model\Torrent) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(TorrentTableMap::DATABASE_NAME);
            $criteria->add(TorrentTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = TorrentQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            TorrentTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                TorrentTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the torrent table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return TorrentQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Torrent or Criteria object.
     *
     * @param mixed               $criteria Criteria or Torrent object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(TorrentTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Torrent object
        }


        // Set the correct dbName
        $query = TorrentQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // TorrentTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
TorrentTableMap::buildTableMap();
