<?php

namespace Odango\Hebi\Model\Map;

use Odango\Hebi\Model\TorrentMetadata;
use Odango\Hebi\Model\TorrentMetadataQuery;
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
 * This class defines the structure of the 'torrent_metadata' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class TorrentMetadataTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.TorrentMetadataTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'torrent_metadata';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Odango\\Hebi\\Model\\TorrentMetadata';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'TorrentMetadata';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 18;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 18;

    /**
     * the column name for the torrent_id field
     */
    const COL_TORRENT_ID = 'torrent_metadata.torrent_id';

    /**
     * the column name for the name field
     */
    const COL_NAME = 'torrent_metadata.name';

    /**
     * the column name for the type field
     */
    const COL_TYPE = 'torrent_metadata.type';

    /**
     * the column name for the version field
     */
    const COL_VERSION = 'torrent_metadata.version';

    /**
     * the column name for the group field
     */
    const COL_GROUP = 'torrent_metadata.group';

    /**
     * the column name for the unparsed field
     */
    const COL_UNPARSED = 'torrent_metadata.unparsed';

    /**
     * the column name for the resolution field
     */
    const COL_RESOLUTION = 'torrent_metadata.resolution';

    /**
     * the column name for the video field
     */
    const COL_VIDEO = 'torrent_metadata.video';

    /**
     * the column name for the video_depth field
     */
    const COL_VIDEO_DEPTH = 'torrent_metadata.video_depth';

    /**
     * the column name for the audio field
     */
    const COL_AUDIO = 'torrent_metadata.audio';

    /**
     * the column name for the source field
     */
    const COL_SOURCE = 'torrent_metadata.source';

    /**
     * the column name for the container field
     */
    const COL_CONTAINER = 'torrent_metadata.container';

    /**
     * the column name for the crc32 field
     */
    const COL_CRC32 = 'torrent_metadata.crc32';

    /**
     * the column name for the ep field
     */
    const COL_EP = 'torrent_metadata.ep';

    /**
     * the column name for the volume field
     */
    const COL_VOLUME = 'torrent_metadata.volume';

    /**
     * the column name for the collection field
     */
    const COL_COLLECTION = 'torrent_metadata.collection';

    /**
     * the column name for the date_created field
     */
    const COL_DATE_CREATED = 'torrent_metadata.date_created';

    /**
     * the column name for the last_updated field
     */
    const COL_LAST_UPDATED = 'torrent_metadata.last_updated';

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
        self::TYPE_PHPNAME       => array('TorrentId', 'Name', 'Type', 'Version', 'Group', 'Unparsed', 'Resolution', 'Video', 'VideoDepth', 'Audio', 'Source', 'Container', 'Crc32', 'Ep', 'Volume', 'Collection', 'DateCreated', 'LastUpdated', ),
        self::TYPE_CAMELNAME     => array('torrentId', 'name', 'type', 'version', 'group', 'unparsed', 'resolution', 'video', 'videoDepth', 'audio', 'source', 'container', 'crc32', 'ep', 'volume', 'collection', 'dateCreated', 'lastUpdated', ),
        self::TYPE_COLNAME       => array(TorrentMetadataTableMap::COL_TORRENT_ID, TorrentMetadataTableMap::COL_NAME, TorrentMetadataTableMap::COL_TYPE, TorrentMetadataTableMap::COL_VERSION, TorrentMetadataTableMap::COL_GROUP, TorrentMetadataTableMap::COL_UNPARSED, TorrentMetadataTableMap::COL_RESOLUTION, TorrentMetadataTableMap::COL_VIDEO, TorrentMetadataTableMap::COL_VIDEO_DEPTH, TorrentMetadataTableMap::COL_AUDIO, TorrentMetadataTableMap::COL_SOURCE, TorrentMetadataTableMap::COL_CONTAINER, TorrentMetadataTableMap::COL_CRC32, TorrentMetadataTableMap::COL_EP, TorrentMetadataTableMap::COL_VOLUME, TorrentMetadataTableMap::COL_COLLECTION, TorrentMetadataTableMap::COL_DATE_CREATED, TorrentMetadataTableMap::COL_LAST_UPDATED, ),
        self::TYPE_FIELDNAME     => array('torrent_id', 'name', 'type', 'version', 'group', 'unparsed', 'resolution', 'video', 'video_depth', 'audio', 'source', 'container', 'crc32', 'ep', 'volume', 'collection', 'date_created', 'last_updated', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('TorrentId' => 0, 'Name' => 1, 'Type' => 2, 'Version' => 3, 'Group' => 4, 'Unparsed' => 5, 'Resolution' => 6, 'Video' => 7, 'VideoDepth' => 8, 'Audio' => 9, 'Source' => 10, 'Container' => 11, 'Crc32' => 12, 'Ep' => 13, 'Volume' => 14, 'Collection' => 15, 'DateCreated' => 16, 'LastUpdated' => 17, ),
        self::TYPE_CAMELNAME     => array('torrentId' => 0, 'name' => 1, 'type' => 2, 'version' => 3, 'group' => 4, 'unparsed' => 5, 'resolution' => 6, 'video' => 7, 'videoDepth' => 8, 'audio' => 9, 'source' => 10, 'container' => 11, 'crc32' => 12, 'ep' => 13, 'volume' => 14, 'collection' => 15, 'dateCreated' => 16, 'lastUpdated' => 17, ),
        self::TYPE_COLNAME       => array(TorrentMetadataTableMap::COL_TORRENT_ID => 0, TorrentMetadataTableMap::COL_NAME => 1, TorrentMetadataTableMap::COL_TYPE => 2, TorrentMetadataTableMap::COL_VERSION => 3, TorrentMetadataTableMap::COL_GROUP => 4, TorrentMetadataTableMap::COL_UNPARSED => 5, TorrentMetadataTableMap::COL_RESOLUTION => 6, TorrentMetadataTableMap::COL_VIDEO => 7, TorrentMetadataTableMap::COL_VIDEO_DEPTH => 8, TorrentMetadataTableMap::COL_AUDIO => 9, TorrentMetadataTableMap::COL_SOURCE => 10, TorrentMetadataTableMap::COL_CONTAINER => 11, TorrentMetadataTableMap::COL_CRC32 => 12, TorrentMetadataTableMap::COL_EP => 13, TorrentMetadataTableMap::COL_VOLUME => 14, TorrentMetadataTableMap::COL_COLLECTION => 15, TorrentMetadataTableMap::COL_DATE_CREATED => 16, TorrentMetadataTableMap::COL_LAST_UPDATED => 17, ),
        self::TYPE_FIELDNAME     => array('torrent_id' => 0, 'name' => 1, 'type' => 2, 'version' => 3, 'group' => 4, 'unparsed' => 5, 'resolution' => 6, 'video' => 7, 'video_depth' => 8, 'audio' => 9, 'source' => 10, 'container' => 11, 'crc32' => 12, 'ep' => 13, 'volume' => 14, 'collection' => 15, 'date_created' => 16, 'last_updated' => 17, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, )
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
        $this->setName('torrent_metadata');
        $this->setPhpName('TorrentMetadata');
        $this->setIdentifierQuoting(true);
        $this->setClassName('\\Odango\\Hebi\\Model\\TorrentMetadata');
        $this->setPackage('');
        $this->setUseIdGenerator(false);
        // columns
        $this->addForeignPrimaryKey('torrent_id', 'TorrentId', 'BIGINT' , 'torrent', 'id', true, null, null);
        $this->addColumn('name', 'Name', 'LONGVARCHAR', false, 255, null);
        $this->addColumn('type', 'Type', 'VARCHAR', false, 255, null);
        $this->addColumn('version', 'Version', 'VARCHAR', false, 255, null);
        $this->addColumn('group', 'Group', 'VARCHAR', false, 255, null);
        $this->addColumn('unparsed', 'Unparsed', 'ARRAY', false, null, null);
        $this->addColumn('resolution', 'Resolution', 'VARCHAR', false, 255, null);
        $this->addColumn('video', 'Video', 'VARCHAR', false, 255, null);
        $this->addColumn('video_depth', 'VideoDepth', 'VARCHAR', false, 255, null);
        $this->addColumn('audio', 'Audio', 'VARCHAR', false, 255, null);
        $this->addColumn('source', 'Source', 'VARCHAR', false, 255, null);
        $this->addColumn('container', 'Container', 'VARCHAR', false, 255, null);
        $this->addColumn('crc32', 'Crc32', 'VARCHAR', false, 255, null);
        $this->addColumn('ep', 'Ep', 'VARCHAR', false, 255, null);
        $this->addColumn('volume', 'Volume', 'VARCHAR', false, 255, null);
        $this->addColumn('collection', 'Collection', 'ARRAY', false, 255, null);
        $this->addColumn('date_created', 'DateCreated', 'TIMESTAMP', false, null, null);
        $this->addColumn('last_updated', 'LastUpdated', 'TIMESTAMP', false, null, null);
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
            'timestampable' => array('create_column' => 'date_created', 'update_column' => 'last_updated', 'disable_created_at' => 'false', 'disable_updated_at' => 'false', ),
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
        return $withPrefix ? TorrentMetadataTableMap::CLASS_DEFAULT : TorrentMetadataTableMap::OM_CLASS;
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
     * @return array           (TorrentMetadata object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = TorrentMetadataTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = TorrentMetadataTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + TorrentMetadataTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = TorrentMetadataTableMap::OM_CLASS;
            /** @var TorrentMetadata $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            TorrentMetadataTableMap::addInstanceToPool($obj, $key);
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
            $key = TorrentMetadataTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = TorrentMetadataTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var TorrentMetadata $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                TorrentMetadataTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(TorrentMetadataTableMap::COL_TORRENT_ID);
            $criteria->addSelectColumn(TorrentMetadataTableMap::COL_NAME);
            $criteria->addSelectColumn(TorrentMetadataTableMap::COL_TYPE);
            $criteria->addSelectColumn(TorrentMetadataTableMap::COL_VERSION);
            $criteria->addSelectColumn(TorrentMetadataTableMap::COL_GROUP);
            $criteria->addSelectColumn(TorrentMetadataTableMap::COL_UNPARSED);
            $criteria->addSelectColumn(TorrentMetadataTableMap::COL_RESOLUTION);
            $criteria->addSelectColumn(TorrentMetadataTableMap::COL_VIDEO);
            $criteria->addSelectColumn(TorrentMetadataTableMap::COL_VIDEO_DEPTH);
            $criteria->addSelectColumn(TorrentMetadataTableMap::COL_AUDIO);
            $criteria->addSelectColumn(TorrentMetadataTableMap::COL_SOURCE);
            $criteria->addSelectColumn(TorrentMetadataTableMap::COL_CONTAINER);
            $criteria->addSelectColumn(TorrentMetadataTableMap::COL_CRC32);
            $criteria->addSelectColumn(TorrentMetadataTableMap::COL_EP);
            $criteria->addSelectColumn(TorrentMetadataTableMap::COL_VOLUME);
            $criteria->addSelectColumn(TorrentMetadataTableMap::COL_COLLECTION);
            $criteria->addSelectColumn(TorrentMetadataTableMap::COL_DATE_CREATED);
            $criteria->addSelectColumn(TorrentMetadataTableMap::COL_LAST_UPDATED);
        } else {
            $criteria->addSelectColumn($alias . '.torrent_id');
            $criteria->addSelectColumn($alias . '.name');
            $criteria->addSelectColumn($alias . '.type');
            $criteria->addSelectColumn($alias . '.version');
            $criteria->addSelectColumn($alias . '.group');
            $criteria->addSelectColumn($alias . '.unparsed');
            $criteria->addSelectColumn($alias . '.resolution');
            $criteria->addSelectColumn($alias . '.video');
            $criteria->addSelectColumn($alias . '.video_depth');
            $criteria->addSelectColumn($alias . '.audio');
            $criteria->addSelectColumn($alias . '.source');
            $criteria->addSelectColumn($alias . '.container');
            $criteria->addSelectColumn($alias . '.crc32');
            $criteria->addSelectColumn($alias . '.ep');
            $criteria->addSelectColumn($alias . '.volume');
            $criteria->addSelectColumn($alias . '.collection');
            $criteria->addSelectColumn($alias . '.date_created');
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
        return Propel::getServiceContainer()->getDatabaseMap(TorrentMetadataTableMap::DATABASE_NAME)->getTable(TorrentMetadataTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(TorrentMetadataTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(TorrentMetadataTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new TorrentMetadataTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a TorrentMetadata or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or TorrentMetadata object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(TorrentMetadataTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Odango\Hebi\Model\TorrentMetadata) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(TorrentMetadataTableMap::DATABASE_NAME);
            $criteria->add(TorrentMetadataTableMap::COL_TORRENT_ID, (array) $values, Criteria::IN);
        }

        $query = TorrentMetadataQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            TorrentMetadataTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                TorrentMetadataTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the torrent_metadata table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return TorrentMetadataQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a TorrentMetadata or Criteria object.
     *
     * @param mixed               $criteria Criteria or TorrentMetadata object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(TorrentMetadataTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from TorrentMetadata object
        }


        // Set the correct dbName
        $query = TorrentMetadataQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // TorrentMetadataTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
TorrentMetadataTableMap::buildTableMap();
