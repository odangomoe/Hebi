<?php

namespace Odango\Hebi\Model\Base;

use \DateTime;
use \Exception;
use \PDO;
use Odango\Hebi\Model\Torrent as ChildTorrent;
use Odango\Hebi\Model\TorrentMetadata as ChildTorrentMetadata;
use Odango\Hebi\Model\TorrentMetadataQuery as ChildTorrentMetadataQuery;
use Odango\Hebi\Model\TorrentQuery as ChildTorrentQuery;
use Odango\Hebi\Model\TorrentStatus as ChildTorrentStatus;
use Odango\Hebi\Model\TorrentStatusQuery as ChildTorrentStatusQuery;
use Odango\Hebi\Model\Map\TorrentTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;
use Propel\Runtime\Util\PropelDateTime;

/**
 * Base class that represents a row from the 'torrent' table.
 *
 *
 *
 * @package    propel.generator..Base
 */
abstract class Torrent implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Odango\\Hebi\\Model\\Map\\TorrentTableMap';


    /**
     * attribute to determine if this object has previously been saved.
     * @var boolean
     */
    protected $new = true;

    /**
     * attribute to determine whether this object has been deleted.
     * @var boolean
     */
    protected $deleted = false;

    /**
     * The columns that have been modified in current object.
     * Tracking modified columns allows us to only update modified columns.
     * @var array
     */
    protected $modifiedColumns = array();

    /**
     * The (virtual) columns that are added at runtime
     * The formatters can add supplementary columns based on a resultset
     * @var array
     */
    protected $virtualColumns = array();

    /**
     * The value for the id field.
     *
     * @var        string
     */
    protected $id;

    /**
     * The value for the info_hash field.
     *
     * @var        string
     */
    protected $info_hash;

    /**
     * The value for the cached_torrent_file field.
     *
     * @var        string
     */
    protected $cached_torrent_file;

    /**
     * The value for the torrent_title field.
     *
     * @var        string
     */
    protected $torrent_title;

    /**
     * The value for the submitter_id field.
     *
     * @var        string
     */
    protected $submitter_id;

    /**
     * The value for the trackers field.
     *
     * @var        array
     */
    protected $trackers;

    /**
     * The unserialized $trackers value - i.e. the persisted object.
     * This is necessary to avoid repeated calls to unserialize() at runtime.
     * @var object
     */
    protected $trackers_unserialized;

    /**
     * The value for the date_crawled field.
     *
     * @var        DateTime
     */
    protected $date_crawled;

    /**
     * The value for the last_updated field.
     *
     * @var        DateTime
     */
    protected $last_updated;

    /**
     * @var        ChildTorrentStatus one-to-one related ChildTorrentStatus object
     */
    protected $singleTorrentStatus;

    /**
     * @var        ChildTorrentMetadata one-to-one related ChildTorrentMetadata object
     */
    protected $singleTorrentMetadata;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * Initializes internal state of Odango\Hebi\Model\Base\Torrent object.
     */
    public function __construct()
    {
    }

    /**
     * Returns whether the object has been modified.
     *
     * @return boolean True if the object has been modified.
     */
    public function isModified()
    {
        return !!$this->modifiedColumns;
    }

    /**
     * Has specified column been modified?
     *
     * @param  string  $col column fully qualified name (TableMap::TYPE_COLNAME), e.g. Book::AUTHOR_ID
     * @return boolean True if $col has been modified.
     */
    public function isColumnModified($col)
    {
        return $this->modifiedColumns && isset($this->modifiedColumns[$col]);
    }

    /**
     * Get the columns that have been modified in this object.
     * @return array A unique list of the modified column names for this object.
     */
    public function getModifiedColumns()
    {
        return $this->modifiedColumns ? array_keys($this->modifiedColumns) : [];
    }

    /**
     * Returns whether the object has ever been saved.  This will
     * be false, if the object was retrieved from storage or was created
     * and then saved.
     *
     * @return boolean true, if the object has never been persisted.
     */
    public function isNew()
    {
        return $this->new;
    }

    /**
     * Setter for the isNew attribute.  This method will be called
     * by Propel-generated children and objects.
     *
     * @param boolean $b the state of the object.
     */
    public function setNew($b)
    {
        $this->new = (boolean) $b;
    }

    /**
     * Whether this object has been deleted.
     * @return boolean The deleted state of this object.
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * Specify whether this object has been deleted.
     * @param  boolean $b The deleted state of this object.
     * @return void
     */
    public function setDeleted($b)
    {
        $this->deleted = (boolean) $b;
    }

    /**
     * Sets the modified state for the object to be false.
     * @param  string $col If supplied, only the specified column is reset.
     * @return void
     */
    public function resetModified($col = null)
    {
        if (null !== $col) {
            if (isset($this->modifiedColumns[$col])) {
                unset($this->modifiedColumns[$col]);
            }
        } else {
            $this->modifiedColumns = array();
        }
    }

    /**
     * Compares this with another <code>Torrent</code> instance.  If
     * <code>obj</code> is an instance of <code>Torrent</code>, delegates to
     * <code>equals(Torrent)</code>.  Otherwise, returns <code>false</code>.
     *
     * @param  mixed   $obj The object to compare to.
     * @return boolean Whether equal to the object specified.
     */
    public function equals($obj)
    {
        if (!$obj instanceof static) {
            return false;
        }

        if ($this === $obj) {
            return true;
        }

        if (null === $this->getPrimaryKey() || null === $obj->getPrimaryKey()) {
            return false;
        }

        return $this->getPrimaryKey() === $obj->getPrimaryKey();
    }

    /**
     * Get the associative array of the virtual columns in this object
     *
     * @return array
     */
    public function getVirtualColumns()
    {
        return $this->virtualColumns;
    }

    /**
     * Checks the existence of a virtual column in this object
     *
     * @param  string  $name The virtual column name
     * @return boolean
     */
    public function hasVirtualColumn($name)
    {
        return array_key_exists($name, $this->virtualColumns);
    }

    /**
     * Get the value of a virtual column in this object
     *
     * @param  string $name The virtual column name
     * @return mixed
     *
     * @throws PropelException
     */
    public function getVirtualColumn($name)
    {
        if (!$this->hasVirtualColumn($name)) {
            throw new PropelException(sprintf('Cannot get value of inexistent virtual column %s.', $name));
        }

        return $this->virtualColumns[$name];
    }

    /**
     * Set the value of a virtual column in this object
     *
     * @param string $name  The virtual column name
     * @param mixed  $value The value to give to the virtual column
     *
     * @return $this|Torrent The current object, for fluid interface
     */
    public function setVirtualColumn($name, $value)
    {
        $this->virtualColumns[$name] = $value;

        return $this;
    }

    /**
     * Logs a message using Propel::log().
     *
     * @param  string  $msg
     * @param  int     $priority One of the Propel::LOG_* logging levels
     * @return boolean
     */
    protected function log($msg, $priority = Propel::LOG_INFO)
    {
        return Propel::log(get_class($this) . ': ' . $msg, $priority);
    }

    /**
     * Export the current object properties to a string, using a given parser format
     * <code>
     * $book = BookQuery::create()->findPk(9012);
     * echo $book->exportTo('JSON');
     *  => {"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param  mixed   $parser                 A AbstractParser instance, or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param  boolean $includeLazyLoadColumns (optional) Whether to include lazy load(ed) columns. Defaults to TRUE.
     * @return string  The exported data
     */
    public function exportTo($parser, $includeLazyLoadColumns = true)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        return $parser->fromArray($this->toArray(TableMap::TYPE_PHPNAME, $includeLazyLoadColumns, array(), true));
    }

    /**
     * Clean up internal collections prior to serializing
     * Avoids recursive loops that turn into segmentation faults when serializing
     */
    public function __sleep()
    {
        $this->clearAllReferences();

        $cls = new \ReflectionClass($this);
        $propertyNames = [];
        $serializableProperties = array_diff($cls->getProperties(), $cls->getProperties(\ReflectionProperty::IS_STATIC));

        foreach($serializableProperties as $property) {
            $propertyNames[] = $property->getName();
        }

        return $propertyNames;
    }

    /**
     * Get the [id] column value.
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the [info_hash] column value.
     *
     * @return string
     */
    public function getInfoHash()
    {
        return $this->info_hash;
    }

    /**
     * Get the [cached_torrent_file] column value.
     *
     * @return string
     */
    public function getCachedTorrentFile()
    {
        return $this->cached_torrent_file;
    }

    /**
     * Get the [torrent_title] column value.
     *
     * @return string
     */
    public function getTorrentTitle()
    {
        return $this->torrent_title;
    }

    /**
     * Get the [submitter_id] column value.
     *
     * @return string
     */
    public function getSubmitterId()
    {
        return $this->submitter_id;
    }

    /**
     * Get the [trackers] column value.
     *
     * @return array
     */
    public function getTrackers()
    {
        if (null === $this->trackers_unserialized) {
            $this->trackers_unserialized = array();
        }
        if (!$this->trackers_unserialized && null !== $this->trackers) {
            $trackers_unserialized = substr($this->trackers, 2, -2);
            $this->trackers_unserialized = '' !== $trackers_unserialized ? explode(' | ', $trackers_unserialized) : array();
        }

        return $this->trackers_unserialized;
    }

    /**
     * Test the presence of a value in the [trackers] array column value.
     * @param      mixed $value
     *
     * @return boolean
     */
    public function hasTracker($value)
    {
        return in_array($value, $this->getTrackers());
    } // hasTracker()

    /**
     * Get the [optionally formatted] temporal [date_crawled] column value.
     *
     *
     * @param      string|null $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getDateCrawled($format = NULL)
    {
        if ($format === null) {
            return $this->date_crawled;
        } else {
            return $this->date_crawled instanceof \DateTimeInterface ? $this->date_crawled->format($format) : null;
        }
    }

    /**
     * Get the [optionally formatted] temporal [last_updated] column value.
     *
     *
     * @param      string|null $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getLastUpdated($format = NULL)
    {
        if ($format === null) {
            return $this->last_updated;
        } else {
            return $this->last_updated instanceof \DateTimeInterface ? $this->last_updated->format($format) : null;
        }
    }

    /**
     * Set the value of [id] column.
     *
     * @param string $v new value
     * @return $this|\Odango\Hebi\Model\Torrent The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[TorrentTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [info_hash] column.
     *
     * @param string $v new value
     * @return $this|\Odango\Hebi\Model\Torrent The current object (for fluent API support)
     */
    public function setInfoHash($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->info_hash !== $v) {
            $this->info_hash = $v;
            $this->modifiedColumns[TorrentTableMap::COL_INFO_HASH] = true;
        }

        return $this;
    } // setInfoHash()

    /**
     * Set the value of [cached_torrent_file] column.
     *
     * @param string $v new value
     * @return $this|\Odango\Hebi\Model\Torrent The current object (for fluent API support)
     */
    public function setCachedTorrentFile($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->cached_torrent_file !== $v) {
            $this->cached_torrent_file = $v;
            $this->modifiedColumns[TorrentTableMap::COL_CACHED_TORRENT_FILE] = true;
        }

        return $this;
    } // setCachedTorrentFile()

    /**
     * Set the value of [torrent_title] column.
     *
     * @param string $v new value
     * @return $this|\Odango\Hebi\Model\Torrent The current object (for fluent API support)
     */
    public function setTorrentTitle($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->torrent_title !== $v) {
            $this->torrent_title = $v;
            $this->modifiedColumns[TorrentTableMap::COL_TORRENT_TITLE] = true;
        }

        return $this;
    } // setTorrentTitle()

    /**
     * Set the value of [submitter_id] column.
     *
     * @param string $v new value
     * @return $this|\Odango\Hebi\Model\Torrent The current object (for fluent API support)
     */
    public function setSubmitterId($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->submitter_id !== $v) {
            $this->submitter_id = $v;
            $this->modifiedColumns[TorrentTableMap::COL_SUBMITTER_ID] = true;
        }

        return $this;
    } // setSubmitterId()

    /**
     * Set the value of [trackers] column.
     *
     * @param array $v new value
     * @return $this|\Odango\Hebi\Model\Torrent The current object (for fluent API support)
     */
    public function setTrackers($v)
    {
        if ($this->trackers_unserialized !== $v) {
            $this->trackers_unserialized = $v;
            $this->trackers = '| ' . implode(' | ', $v) . ' |';
            $this->modifiedColumns[TorrentTableMap::COL_TRACKERS] = true;
        }

        return $this;
    } // setTrackers()

    /**
     * Adds a value to the [trackers] array column value.
     * @param  mixed $value
     *
     * @return $this|\Odango\Hebi\Model\Torrent The current object (for fluent API support)
     */
    public function addTracker($value)
    {
        $currentArray = $this->getTrackers();
        $currentArray []= $value;
        $this->setTrackers($currentArray);

        return $this;
    } // addTracker()

    /**
     * Removes a value from the [trackers] array column value.
     * @param  mixed $value
     *
     * @return $this|\Odango\Hebi\Model\Torrent The current object (for fluent API support)
     */
    public function removeTracker($value)
    {
        $targetArray = array();
        foreach ($this->getTrackers() as $element) {
            if ($element != $value) {
                $targetArray []= $element;
            }
        }
        $this->setTrackers($targetArray);

        return $this;
    } // removeTracker()

    /**
     * Sets the value of [date_crawled] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\Odango\Hebi\Model\Torrent The current object (for fluent API support)
     */
    public function setDateCrawled($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->date_crawled !== null || $dt !== null) {
            if ($this->date_crawled === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->date_crawled->format("Y-m-d H:i:s.u")) {
                $this->date_crawled = $dt === null ? null : clone $dt;
                $this->modifiedColumns[TorrentTableMap::COL_DATE_CRAWLED] = true;
            }
        } // if either are not null

        return $this;
    } // setDateCrawled()

    /**
     * Sets the value of [last_updated] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\Odango\Hebi\Model\Torrent The current object (for fluent API support)
     */
    public function setLastUpdated($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->last_updated !== null || $dt !== null) {
            if ($this->last_updated === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->last_updated->format("Y-m-d H:i:s.u")) {
                $this->last_updated = $dt === null ? null : clone $dt;
                $this->modifiedColumns[TorrentTableMap::COL_LAST_UPDATED] = true;
            }
        } // if either are not null

        return $this;
    } // setLastUpdated()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
        // otherwise, everything was equal, so return TRUE
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array   $row       The row returned by DataFetcher->fetch().
     * @param int     $startcol  0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @param string  $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                  One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false, $indexType = TableMap::TYPE_NUM)
    {
        try {

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : TorrentTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : TorrentTableMap::translateFieldName('InfoHash', TableMap::TYPE_PHPNAME, $indexType)];
            $this->info_hash = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : TorrentTableMap::translateFieldName('CachedTorrentFile', TableMap::TYPE_PHPNAME, $indexType)];
            $this->cached_torrent_file = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : TorrentTableMap::translateFieldName('TorrentTitle', TableMap::TYPE_PHPNAME, $indexType)];
            $this->torrent_title = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : TorrentTableMap::translateFieldName('SubmitterId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->submitter_id = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : TorrentTableMap::translateFieldName('Trackers', TableMap::TYPE_PHPNAME, $indexType)];
            $this->trackers = $col;
            $this->trackers_unserialized = null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : TorrentTableMap::translateFieldName('DateCrawled', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->date_crawled = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : TorrentTableMap::translateFieldName('LastUpdated', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->last_updated = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 8; // 8 = TorrentTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Odango\\Hebi\\Model\\Torrent'), 0, $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {
    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param      boolean $deep (optional) Whether to also de-associated any related objects.
     * @param      ConnectionInterface $con (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(TorrentTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildTorrentQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->singleTorrentStatus = null;

            $this->singleTorrentMetadata = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Torrent::setDeleted()
     * @see Torrent::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(TorrentTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildTorrentQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $this->setDeleted(true);
            }
        });
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see doSave()
     */
    public function save(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($this->alreadyInSave) {
            return 0;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(TorrentTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $ret = $this->preSave($con);
            $isInsert = $this->isNew();
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
                // timestampable behavior
                $time = time();
                $highPrecision = \Propel\Runtime\Util\PropelDateTime::createHighPrecision();
                if (!$this->isColumnModified(TorrentTableMap::COL_DATE_CRAWLED)) {
                    $this->setDateCrawled($highPrecision);
                }
                if (!$this->isColumnModified(TorrentTableMap::COL_LAST_UPDATED)) {
                    $this->setLastUpdated($highPrecision);
                }
            } else {
                $ret = $ret && $this->preUpdate($con);
                // timestampable behavior
                if ($this->isModified() && !$this->isColumnModified(TorrentTableMap::COL_LAST_UPDATED)) {
                    $this->setLastUpdated(\Propel\Runtime\Util\PropelDateTime::createHighPrecision());
                }
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                TorrentTableMap::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }

            return $affectedRows;
        });
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see save()
     */
    protected function doSave(ConnectionInterface $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                    $affectedRows += 1;
                } else {
                    $affectedRows += $this->doUpdate($con);
                }
                $this->resetModified();
            }

            if ($this->singleTorrentStatus !== null) {
                if (!$this->singleTorrentStatus->isDeleted() && ($this->singleTorrentStatus->isNew() || $this->singleTorrentStatus->isModified())) {
                    $affectedRows += $this->singleTorrentStatus->save($con);
                }
            }

            if ($this->singleTorrentMetadata !== null) {
                if (!$this->singleTorrentMetadata->isDeleted() && ($this->singleTorrentMetadata->isNew() || $this->singleTorrentMetadata->isModified())) {
                    $affectedRows += $this->singleTorrentMetadata->save($con);
                }
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @throws PropelException
     * @see doSave()
     */
    protected function doInsert(ConnectionInterface $con)
    {
        $modifiedColumns = array();
        $index = 0;


         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(TorrentTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = '`id`';
        }
        if ($this->isColumnModified(TorrentTableMap::COL_INFO_HASH)) {
            $modifiedColumns[':p' . $index++]  = '`info_hash`';
        }
        if ($this->isColumnModified(TorrentTableMap::COL_CACHED_TORRENT_FILE)) {
            $modifiedColumns[':p' . $index++]  = '`cached_torrent_file`';
        }
        if ($this->isColumnModified(TorrentTableMap::COL_TORRENT_TITLE)) {
            $modifiedColumns[':p' . $index++]  = '`torrent_title`';
        }
        if ($this->isColumnModified(TorrentTableMap::COL_SUBMITTER_ID)) {
            $modifiedColumns[':p' . $index++]  = '`submitter_id`';
        }
        if ($this->isColumnModified(TorrentTableMap::COL_TRACKERS)) {
            $modifiedColumns[':p' . $index++]  = '`trackers`';
        }
        if ($this->isColumnModified(TorrentTableMap::COL_DATE_CRAWLED)) {
            $modifiedColumns[':p' . $index++]  = '`date_crawled`';
        }
        if ($this->isColumnModified(TorrentTableMap::COL_LAST_UPDATED)) {
            $modifiedColumns[':p' . $index++]  = '`last_updated`';
        }

        $sql = sprintf(
            'INSERT INTO `torrent` (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case '`id`':
                        $stmt->bindValue($identifier, $this->id, PDO::PARAM_INT);
                        break;
                    case '`info_hash`':
                        $stmt->bindValue($identifier, $this->info_hash, PDO::PARAM_STR);
                        break;
                    case '`cached_torrent_file`':
                        $stmt->bindValue($identifier, $this->cached_torrent_file, PDO::PARAM_STR);
                        break;
                    case '`torrent_title`':
                        $stmt->bindValue($identifier, $this->torrent_title, PDO::PARAM_STR);
                        break;
                    case '`submitter_id`':
                        $stmt->bindValue($identifier, $this->submitter_id, PDO::PARAM_INT);
                        break;
                    case '`trackers`':
                        $stmt->bindValue($identifier, $this->trackers, PDO::PARAM_STR);
                        break;
                    case '`date_crawled`':
                        $stmt->bindValue($identifier, $this->date_crawled ? $this->date_crawled->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
                        break;
                    case '`last_updated`':
                        $stmt->bindValue($identifier, $this->last_updated ? $this->last_updated->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @return Integer Number of updated rows
     * @see doSave()
     */
    protected function doUpdate(ConnectionInterface $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();

        return $selectCriteria->doUpdate($valuesCriteria, $con);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param      string $name name
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return mixed Value of field.
     */
    public function getByName($name, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = TorrentTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getId();
                break;
            case 1:
                return $this->getInfoHash();
                break;
            case 2:
                return $this->getCachedTorrentFile();
                break;
            case 3:
                return $this->getTorrentTitle();
                break;
            case 4:
                return $this->getSubmitterId();
                break;
            case 5:
                return $this->getTrackers();
                break;
            case 6:
                return $this->getDateCrawled();
                break;
            case 7:
                return $this->getLastUpdated();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     *                    TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                    Defaults to TableMap::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = TableMap::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {

        if (isset($alreadyDumpedObjects['Torrent'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Torrent'][$this->hashCode()] = true;
        $keys = TorrentTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getInfoHash(),
            $keys[2] => $this->getCachedTorrentFile(),
            $keys[3] => $this->getTorrentTitle(),
            $keys[4] => $this->getSubmitterId(),
            $keys[5] => $this->getTrackers(),
            $keys[6] => $this->getDateCrawled(),
            $keys[7] => $this->getLastUpdated(),
        );
        if ($result[$keys[6]] instanceof \DateTimeInterface) {
            $result[$keys[6]] = $result[$keys[6]]->format('c');
        }

        if ($result[$keys[7]] instanceof \DateTimeInterface) {
            $result[$keys[7]] = $result[$keys[7]]->format('c');
        }

        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->singleTorrentStatus) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'torrentStatus';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'torrent_status';
                        break;
                    default:
                        $key = 'TorrentStatus';
                }

                $result[$key] = $this->singleTorrentStatus->toArray($keyType, $includeLazyLoadColumns, $alreadyDumpedObjects, true);
            }
            if (null !== $this->singleTorrentMetadata) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'torrentMetadata';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'torrent_metadata';
                        break;
                    default:
                        $key = 'TorrentMetadata';
                }

                $result[$key] = $this->singleTorrentMetadata->toArray($keyType, $includeLazyLoadColumns, $alreadyDumpedObjects, true);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param  string $name
     * @param  mixed  $value field value
     * @param  string $type The type of fieldname the $name is of:
     *                one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                Defaults to TableMap::TYPE_PHPNAME.
     * @return $this|\Odango\Hebi\Model\Torrent
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = TorrentTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Odango\Hebi\Model\Torrent
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setInfoHash($value);
                break;
            case 2:
                $this->setCachedTorrentFile($value);
                break;
            case 3:
                $this->setTorrentTitle($value);
                break;
            case 4:
                $this->setSubmitterId($value);
                break;
            case 5:
                if (!is_array($value)) {
                    $v = trim(substr($value, 2, -2));
                    $value = $v ? explode(' | ', $v) : array();
                }
                $this->setTrackers($value);
                break;
            case 6:
                $this->setDateCrawled($value);
                break;
            case 7:
                $this->setLastUpdated($value);
                break;
        } // switch()

        return $this;
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param      array  $arr     An array to populate the object from.
     * @param      string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = TorrentTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setInfoHash($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setCachedTorrentFile($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setTorrentTitle($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setSubmitterId($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setTrackers($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setDateCrawled($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setLastUpdated($arr[$keys[7]]);
        }
    }

     /**
     * Populate the current object from a string, using a given parser format
     * <code>
     * $book = new Book();
     * $book->importFrom('JSON', '{"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param mixed $parser A AbstractParser instance,
     *                       or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param string $data The source data to import from
     * @param string $keyType The type of keys the array uses.
     *
     * @return $this|\Odango\Hebi\Model\Torrent The current object, for fluid interface
     */
    public function importFrom($parser, $data, $keyType = TableMap::TYPE_PHPNAME)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        $this->fromArray($parser->toArray($data), $keyType);

        return $this;
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(TorrentTableMap::DATABASE_NAME);

        if ($this->isColumnModified(TorrentTableMap::COL_ID)) {
            $criteria->add(TorrentTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(TorrentTableMap::COL_INFO_HASH)) {
            $criteria->add(TorrentTableMap::COL_INFO_HASH, $this->info_hash);
        }
        if ($this->isColumnModified(TorrentTableMap::COL_CACHED_TORRENT_FILE)) {
            $criteria->add(TorrentTableMap::COL_CACHED_TORRENT_FILE, $this->cached_torrent_file);
        }
        if ($this->isColumnModified(TorrentTableMap::COL_TORRENT_TITLE)) {
            $criteria->add(TorrentTableMap::COL_TORRENT_TITLE, $this->torrent_title);
        }
        if ($this->isColumnModified(TorrentTableMap::COL_SUBMITTER_ID)) {
            $criteria->add(TorrentTableMap::COL_SUBMITTER_ID, $this->submitter_id);
        }
        if ($this->isColumnModified(TorrentTableMap::COL_TRACKERS)) {
            $criteria->add(TorrentTableMap::COL_TRACKERS, $this->trackers);
        }
        if ($this->isColumnModified(TorrentTableMap::COL_DATE_CRAWLED)) {
            $criteria->add(TorrentTableMap::COL_DATE_CRAWLED, $this->date_crawled);
        }
        if ($this->isColumnModified(TorrentTableMap::COL_LAST_UPDATED)) {
            $criteria->add(TorrentTableMap::COL_LAST_UPDATED, $this->last_updated);
        }

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @throws LogicException if no primary key is defined
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = ChildTorrentQuery::create();
        $criteria->add(TorrentTableMap::COL_ID, $this->id);

        return $criteria;
    }

    /**
     * If the primary key is not null, return the hashcode of the
     * primary key. Otherwise, return the hash code of the object.
     *
     * @return int Hashcode
     */
    public function hashCode()
    {
        $validPk = null !== $this->getId();

        $validPrimaryKeyFKs = 0;
        $primaryKeyFKs = [];

        if ($validPk) {
            return crc32(json_encode($this->getPrimaryKey(), JSON_UNESCAPED_UNICODE));
        } elseif ($validPrimaryKeyFKs) {
            return crc32(json_encode($primaryKeyFKs, JSON_UNESCAPED_UNICODE));
        }

        return spl_object_hash($this);
    }

    /**
     * Returns the primary key for this object (row).
     * @return string
     */
    public function getPrimaryKey()
    {
        return $this->getId();
    }

    /**
     * Generic method to set the primary key (id column).
     *
     * @param       string $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \Odango\Hebi\Model\Torrent (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setId($this->getId());
        $copyObj->setInfoHash($this->getInfoHash());
        $copyObj->setCachedTorrentFile($this->getCachedTorrentFile());
        $copyObj->setTorrentTitle($this->getTorrentTitle());
        $copyObj->setSubmitterId($this->getSubmitterId());
        $copyObj->setTrackers($this->getTrackers());
        $copyObj->setDateCrawled($this->getDateCrawled());
        $copyObj->setLastUpdated($this->getLastUpdated());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            $relObj = $this->getTorrentStatus();
            if ($relObj) {
                $copyObj->setTorrentStatus($relObj->copy($deepCopy));
            }

            $relObj = $this->getTorrentMetadata();
            if ($relObj) {
                $copyObj->setTorrentMetadata($relObj->copy($deepCopy));
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param  boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return \Odango\Hebi\Model\Torrent Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param      string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
    }

    /**
     * Gets a single ChildTorrentStatus object, which is related to this object by a one-to-one relationship.
     *
     * @param  ConnectionInterface $con optional connection object
     * @return ChildTorrentStatus
     * @throws PropelException
     */
    public function getTorrentStatus(ConnectionInterface $con = null)
    {

        if ($this->singleTorrentStatus === null && !$this->isNew()) {
            $this->singleTorrentStatus = ChildTorrentStatusQuery::create()->findPk($this->getPrimaryKey(), $con);
        }

        return $this->singleTorrentStatus;
    }

    /**
     * Sets a single ChildTorrentStatus object as related to this object by a one-to-one relationship.
     *
     * @param  ChildTorrentStatus $v ChildTorrentStatus
     * @return $this|\Odango\Hebi\Model\Torrent The current object (for fluent API support)
     * @throws PropelException
     */
    public function setTorrentStatus(ChildTorrentStatus $v = null)
    {
        $this->singleTorrentStatus = $v;

        // Make sure that that the passed-in ChildTorrentStatus isn't already associated with this object
        if ($v !== null && $v->getTorrent(null, false) === null) {
            $v->setTorrent($this);
        }

        return $this;
    }

    /**
     * Gets a single ChildTorrentMetadata object, which is related to this object by a one-to-one relationship.
     *
     * @param  ConnectionInterface $con optional connection object
     * @return ChildTorrentMetadata
     * @throws PropelException
     */
    public function getTorrentMetadata(ConnectionInterface $con = null)
    {

        if ($this->singleTorrentMetadata === null && !$this->isNew()) {
            $this->singleTorrentMetadata = ChildTorrentMetadataQuery::create()->findPk($this->getPrimaryKey(), $con);
        }

        return $this->singleTorrentMetadata;
    }

    /**
     * Sets a single ChildTorrentMetadata object as related to this object by a one-to-one relationship.
     *
     * @param  ChildTorrentMetadata $v ChildTorrentMetadata
     * @return $this|\Odango\Hebi\Model\Torrent The current object (for fluent API support)
     * @throws PropelException
     */
    public function setTorrentMetadata(ChildTorrentMetadata $v = null)
    {
        $this->singleTorrentMetadata = $v;

        // Make sure that that the passed-in ChildTorrentMetadata isn't already associated with this object
        if ($v !== null && $v->getTorrent(null, false) === null) {
            $v->setTorrent($this);
        }

        return $this;
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        $this->id = null;
        $this->info_hash = null;
        $this->cached_torrent_file = null;
        $this->torrent_title = null;
        $this->submitter_id = null;
        $this->trackers = null;
        $this->trackers_unserialized = null;
        $this->date_crawled = null;
        $this->last_updated = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references and back-references to other model objects or collections of model objects.
     *
     * This method is used to reset all php object references (not the actual reference in the database).
     * Necessary for object serialisation.
     *
     * @param      boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep) {
            if ($this->singleTorrentStatus) {
                $this->singleTorrentStatus->clearAllReferences($deep);
            }
            if ($this->singleTorrentMetadata) {
                $this->singleTorrentMetadata->clearAllReferences($deep);
            }
        } // if ($deep)

        $this->singleTorrentStatus = null;
        $this->singleTorrentMetadata = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(TorrentTableMap::DEFAULT_STRING_FORMAT);
    }

    // timestampable behavior

    /**
     * Mark the current object so that the update date doesn't get updated during next save
     *
     * @return     $this|ChildTorrent The current object (for fluent API support)
     */
    public function keepUpdateDateUnchanged()
    {
        $this->modifiedColumns[TorrentTableMap::COL_LAST_UPDATED] = true;

        return $this;
    }

    /**
     * Code to be run before persisting the object
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preSave(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preSave')) {
            return parent::preSave($con);
        }
        return true;
    }

    /**
     * Code to be run after persisting the object
     * @param ConnectionInterface $con
     */
    public function postSave(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postSave')) {
            parent::postSave($con);
        }
    }

    /**
     * Code to be run before inserting to database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preInsert(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preInsert')) {
            return parent::preInsert($con);
        }
        return true;
    }

    /**
     * Code to be run after inserting to database
     * @param ConnectionInterface $con
     */
    public function postInsert(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postInsert')) {
            parent::postInsert($con);
        }
    }

    /**
     * Code to be run before updating the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preUpdate(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preUpdate')) {
            return parent::preUpdate($con);
        }
        return true;
    }

    /**
     * Code to be run after updating the object in database
     * @param ConnectionInterface $con
     */
    public function postUpdate(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postUpdate')) {
            parent::postUpdate($con);
        }
    }

    /**
     * Code to be run before deleting the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preDelete(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preDelete')) {
            return parent::preDelete($con);
        }
        return true;
    }

    /**
     * Code to be run after deleting the object in database
     * @param ConnectionInterface $con
     */
    public function postDelete(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postDelete')) {
            parent::postDelete($con);
        }
    }


    /**
     * Derived method to catches calls to undefined methods.
     *
     * Provides magic import/export method support (fromXML()/toXML(), fromYAML()/toYAML(), etc.).
     * Allows to define default __call() behavior if you overwrite __call()
     *
     * @param string $name
     * @param mixed  $params
     *
     * @return array|string
     */
    public function __call($name, $params)
    {
        if (0 === strpos($name, 'get')) {
            $virtualColumn = substr($name, 3);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }

            $virtualColumn = lcfirst($virtualColumn);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }
        }

        if (0 === strpos($name, 'from')) {
            $format = substr($name, 4);

            return $this->importFrom($format, reset($params));
        }

        if (0 === strpos($name, 'to')) {
            $format = substr($name, 2);
            $includeLazyLoadColumns = isset($params[0]) ? $params[0] : true;

            return $this->exportTo($format, $includeLazyLoadColumns);
        }

        throw new BadMethodCallException(sprintf('Call to undefined method: %s.', $name));
    }

}
