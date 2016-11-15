<?php

namespace Odango\Hebi\Model\Map;

use Odango\Hebi\Model\CrawlItem;
use Odango\Hebi\Model\CrawlItemQuery;
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
 * This class defines the structure of the 'crawl_item' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class CrawlItemTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.CrawlItemTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'crawl_item';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Odango\\Hebi\\Model\\CrawlItem';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'CrawlItem';

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
    const COL_ID = 'crawl_item.id';

    /**
     * the column name for the target field
     */
    const COL_TARGET = 'crawl_item.target';

    /**
     * the column name for the external_id field
     */
    const COL_EXTERNAL_ID = 'crawl_item.external_id';

    /**
     * the column name for the status field
     */
    const COL_STATUS = 'crawl_item.status';

    /**
     * the column name for the type field
     */
    const COL_TYPE = 'crawl_item.type';

    /**
     * the column name for the last_updated field
     */
    const COL_LAST_UPDATED = 'crawl_item.last_updated';

    /**
     * the column name for the last_success field
     */
    const COL_LAST_SUCCESS = 'crawl_item.last_success';

    /**
     * the column name for the created_at field
     */
    const COL_CREATED_AT = 'crawl_item.created_at';

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
        self::TYPE_PHPNAME       => array('Id', 'Target', 'ExternalId', 'Status', 'Type', 'LastUpdated', 'LastSuccess', 'CreatedAt', ),
        self::TYPE_CAMELNAME     => array('id', 'target', 'externalId', 'status', 'type', 'lastUpdated', 'lastSuccess', 'createdAt', ),
        self::TYPE_COLNAME       => array(CrawlItemTableMap::COL_ID, CrawlItemTableMap::COL_TARGET, CrawlItemTableMap::COL_EXTERNAL_ID, CrawlItemTableMap::COL_STATUS, CrawlItemTableMap::COL_TYPE, CrawlItemTableMap::COL_LAST_UPDATED, CrawlItemTableMap::COL_LAST_SUCCESS, CrawlItemTableMap::COL_CREATED_AT, ),
        self::TYPE_FIELDNAME     => array('id', 'target', 'external_id', 'status', 'type', 'last_updated', 'last_success', 'created_at', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'Target' => 1, 'ExternalId' => 2, 'Status' => 3, 'Type' => 4, 'LastUpdated' => 5, 'LastSuccess' => 6, 'CreatedAt' => 7, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'target' => 1, 'externalId' => 2, 'status' => 3, 'type' => 4, 'lastUpdated' => 5, 'lastSuccess' => 6, 'createdAt' => 7, ),
        self::TYPE_COLNAME       => array(CrawlItemTableMap::COL_ID => 0, CrawlItemTableMap::COL_TARGET => 1, CrawlItemTableMap::COL_EXTERNAL_ID => 2, CrawlItemTableMap::COL_STATUS => 3, CrawlItemTableMap::COL_TYPE => 4, CrawlItemTableMap::COL_LAST_UPDATED => 5, CrawlItemTableMap::COL_LAST_SUCCESS => 6, CrawlItemTableMap::COL_CREATED_AT => 7, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'target' => 1, 'external_id' => 2, 'status' => 3, 'type' => 4, 'last_updated' => 5, 'last_success' => 6, 'created_at' => 7, ),
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
        $this->setName('crawl_item');
        $this->setPhpName('CrawlItem');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Odango\\Hebi\\Model\\CrawlItem');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'BIGINT', true, null, null);
        $this->addColumn('target', 'Target', 'VARCHAR', false, 255, null);
        $this->addColumn('external_id', 'ExternalId', 'VARCHAR', false, 255, null);
        $this->addColumn('status', 'Status', 'VARCHAR', false, 50, null);
        $this->addColumn('type', 'Type', 'VARCHAR', false, 50, null);
        $this->addColumn('last_updated', 'LastUpdated', 'TIMESTAMP', false, null, null);
        $this->addColumn('last_success', 'LastSuccess', 'TIMESTAMP', false, null, null);
        $this->addColumn('created_at', 'CreatedAt', 'TIMESTAMP', false, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Torrent', '\\Odango\\Hebi\\Model\\Torrent', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':crawl_item_id',
    1 => ':id',
  ),
), null, null, 'Torrents', false);
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
        return $withPrefix ? CrawlItemTableMap::CLASS_DEFAULT : CrawlItemTableMap::OM_CLASS;
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
     * @return array           (CrawlItem object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = CrawlItemTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = CrawlItemTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + CrawlItemTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = CrawlItemTableMap::OM_CLASS;
            /** @var CrawlItem $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            CrawlItemTableMap::addInstanceToPool($obj, $key);
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
            $key = CrawlItemTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = CrawlItemTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var CrawlItem $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                CrawlItemTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(CrawlItemTableMap::COL_ID);
            $criteria->addSelectColumn(CrawlItemTableMap::COL_TARGET);
            $criteria->addSelectColumn(CrawlItemTableMap::COL_EXTERNAL_ID);
            $criteria->addSelectColumn(CrawlItemTableMap::COL_STATUS);
            $criteria->addSelectColumn(CrawlItemTableMap::COL_TYPE);
            $criteria->addSelectColumn(CrawlItemTableMap::COL_LAST_UPDATED);
            $criteria->addSelectColumn(CrawlItemTableMap::COL_LAST_SUCCESS);
            $criteria->addSelectColumn(CrawlItemTableMap::COL_CREATED_AT);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.target');
            $criteria->addSelectColumn($alias . '.external_id');
            $criteria->addSelectColumn($alias . '.status');
            $criteria->addSelectColumn($alias . '.type');
            $criteria->addSelectColumn($alias . '.last_updated');
            $criteria->addSelectColumn($alias . '.last_success');
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
        return Propel::getServiceContainer()->getDatabaseMap(CrawlItemTableMap::DATABASE_NAME)->getTable(CrawlItemTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(CrawlItemTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(CrawlItemTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new CrawlItemTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a CrawlItem or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or CrawlItem object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(CrawlItemTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Odango\Hebi\Model\CrawlItem) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(CrawlItemTableMap::DATABASE_NAME);
            $criteria->add(CrawlItemTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = CrawlItemQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            CrawlItemTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                CrawlItemTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the crawl_item table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return CrawlItemQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a CrawlItem or Criteria object.
     *
     * @param mixed               $criteria Criteria or CrawlItem object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CrawlItemTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from CrawlItem object
        }

        if ($criteria->containsKey(CrawlItemTableMap::COL_ID) && $criteria->keyContainsValue(CrawlItemTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.CrawlItemTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = CrawlItemQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // CrawlItemTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
CrawlItemTableMap::buildTableMap();
