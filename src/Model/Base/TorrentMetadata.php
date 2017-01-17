<?php

namespace Odango\Hebi\Model\Base;

use \DateTime;
use \Exception;
use \PDO;
use Odango\Hebi\Model\Torrent as ChildTorrent;
use Odango\Hebi\Model\TorrentMetadata as ChildTorrentMetadata;
use Odango\Hebi\Model\TorrentMetadataQuery as ChildTorrentMetadataQuery;
use Odango\Hebi\Model\TorrentQuery as ChildTorrentQuery;
use Odango\Hebi\Model\Map\TorrentMetadataTableMap;
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
 * Base class that represents a row from the 'torrent_metadata' table.
 *
 *
 *
 * @package    propel.generator..Base
 */
abstract class TorrentMetadata implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Odango\\Hebi\\Model\\Map\\TorrentMetadataTableMap';


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
     * The value for the torrent_id field.
     *
     * @var        string
     */
    protected $torrent_id;

    /**
     * The value for the name field.
     *
     * @var        string
     */
    protected $name;

    /**
     * The value for the type field.
     *
     * @var        string
     */
    protected $type;

    /**
     * The value for the version field.
     *
     * @var        string
     */
    protected $version;

    /**
     * The value for the group field.
     *
     * @var        string
     */
    protected $group;

    /**
     * The value for the unparsed field.
     *
     * @var        array
     */
    protected $unparsed;

    /**
     * The unserialized $unparsed value - i.e. the persisted object.
     * This is necessary to avoid repeated calls to unserialize() at runtime.
     * @var object
     */
    protected $unparsed_unserialized;

    /**
     * The value for the resolution field.
     *
     * @var        string
     */
    protected $resolution;

    /**
     * The value for the video field.
     *
     * @var        string
     */
    protected $video;

    /**
     * The value for the video_depth field.
     *
     * @var        string
     */
    protected $video_depth;

    /**
     * The value for the audio field.
     *
     * @var        string
     */
    protected $audio;

    /**
     * The value for the source field.
     *
     * @var        string
     */
    protected $source;

    /**
     * The value for the container field.
     *
     * @var        string
     */
    protected $container;

    /**
     * The value for the crc32 field.
     *
     * @var        string
     */
    protected $crc32;

    /**
     * The value for the ep field.
     *
     * @var        array
     */
    protected $ep;

    /**
     * The unserialized $ep value - i.e. the persisted object.
     * This is necessary to avoid repeated calls to unserialize() at runtime.
     * @var object
     */
    protected $ep_unserialized;

    /**
     * The value for the special field.
     *
     * @var        string
     */
    protected $special;

    /**
     * The value for the season field.
     *
     * @var        string
     */
    protected $season;

    /**
     * The value for the volume field.
     *
     * @var        string
     */
    protected $volume;

    /**
     * The value for the collection field.
     *
     * @var        array
     */
    protected $collection;

    /**
     * The unserialized $collection value - i.e. the persisted object.
     * This is necessary to avoid repeated calls to unserialize() at runtime.
     * @var object
     */
    protected $collection_unserialized;

    /**
     * The value for the date_created field.
     *
     * @var        DateTime
     */
    protected $date_created;

    /**
     * The value for the last_updated field.
     *
     * @var        DateTime
     */
    protected $last_updated;

    /**
     * @var        ChildTorrent
     */
    protected $aTorrent;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * Initializes internal state of Odango\Hebi\Model\Base\TorrentMetadata object.
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
     * Compares this with another <code>TorrentMetadata</code> instance.  If
     * <code>obj</code> is an instance of <code>TorrentMetadata</code>, delegates to
     * <code>equals(TorrentMetadata)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|TorrentMetadata The current object, for fluid interface
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
     * Get the [torrent_id] column value.
     *
     * @return string
     */
    public function getTorrentId()
    {
        return $this->torrent_id;
    }

    /**
     * Get the [name] column value.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the [type] column value.
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Get the [version] column value.
     *
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Get the [group] column value.
     *
     * @return string
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * Get the [unparsed] column value.
     *
     * @return array
     */
    public function getUnparsed()
    {
        if (null === $this->unparsed_unserialized) {
            $this->unparsed_unserialized = array();
        }
        if (!$this->unparsed_unserialized && null !== $this->unparsed) {
            $unparsed_unserialized = substr($this->unparsed, 2, -2);
            $this->unparsed_unserialized = '' !== $unparsed_unserialized ? explode(' | ', $unparsed_unserialized) : array();
        }

        return $this->unparsed_unserialized;
    }

    /**
     * Get the [resolution] column value.
     *
     * @return string
     */
    public function getResolution()
    {
        return $this->resolution;
    }

    /**
     * Get the [video] column value.
     *
     * @return string
     */
    public function getVideo()
    {
        return $this->video;
    }

    /**
     * Get the [video_depth] column value.
     *
     * @return string
     */
    public function getVideoDepth()
    {
        return $this->video_depth;
    }

    /**
     * Get the [audio] column value.
     *
     * @return string
     */
    public function getAudio()
    {
        return $this->audio;
    }

    /**
     * Get the [source] column value.
     *
     * @return string
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * Get the [container] column value.
     *
     * @return string
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * Get the [crc32] column value.
     *
     * @return string
     */
    public function getCrc32()
    {
        return $this->crc32;
    }

    /**
     * Get the [ep] column value.
     *
     * @return array
     */
    public function getEp()
    {
        if (null === $this->ep_unserialized) {
            $this->ep_unserialized = array();
        }
        if (!$this->ep_unserialized && null !== $this->ep) {
            $ep_unserialized = substr($this->ep, 2, -2);
            $this->ep_unserialized = '' !== $ep_unserialized ? explode(' | ', $ep_unserialized) : array();
        }

        return $this->ep_unserialized;
    }

    /**
     * Get the [special] column value.
     *
     * @return string
     */
    public function getSpecial()
    {
        return $this->special;
    }

    /**
     * Get the [season] column value.
     *
     * @return string
     */
    public function getSeason()
    {
        return $this->season;
    }

    /**
     * Get the [volume] column value.
     *
     * @return string
     */
    public function getVolume()
    {
        return $this->volume;
    }

    /**
     * Get the [collection] column value.
     *
     * @return array
     */
    public function getCollection()
    {
        if (null === $this->collection_unserialized) {
            $this->collection_unserialized = array();
        }
        if (!$this->collection_unserialized && null !== $this->collection) {
            $collection_unserialized = substr($this->collection, 2, -2);
            $this->collection_unserialized = '' !== $collection_unserialized ? explode(' | ', $collection_unserialized) : array();
        }

        return $this->collection_unserialized;
    }

    /**
     * Get the [optionally formatted] temporal [date_created] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getDateCreated($format = NULL)
    {
        if ($format === null) {
            return $this->date_created;
        } else {
            return $this->date_created instanceof \DateTimeInterface ? $this->date_created->format($format) : null;
        }
    }

    /**
     * Get the [optionally formatted] temporal [last_updated] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
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
     * Set the value of [torrent_id] column.
     *
     * @param string $v new value
     * @return $this|\Odango\Hebi\Model\TorrentMetadata The current object (for fluent API support)
     */
    public function setTorrentId($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->torrent_id !== $v) {
            $this->torrent_id = $v;
            $this->modifiedColumns[TorrentMetadataTableMap::COL_TORRENT_ID] = true;
        }

        if ($this->aTorrent !== null && $this->aTorrent->getId() !== $v) {
            $this->aTorrent = null;
        }

        return $this;
    } // setTorrentId()

    /**
     * Set the value of [name] column.
     *
     * @param string $v new value
     * @return $this|\Odango\Hebi\Model\TorrentMetadata The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[TorrentMetadataTableMap::COL_NAME] = true;
        }

        return $this;
    } // setName()

    /**
     * Set the value of [type] column.
     *
     * @param string $v new value
     * @return $this|\Odango\Hebi\Model\TorrentMetadata The current object (for fluent API support)
     */
    public function setType($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->type !== $v) {
            $this->type = $v;
            $this->modifiedColumns[TorrentMetadataTableMap::COL_TYPE] = true;
        }

        return $this;
    } // setType()

    /**
     * Set the value of [version] column.
     *
     * @param string $v new value
     * @return $this|\Odango\Hebi\Model\TorrentMetadata The current object (for fluent API support)
     */
    public function setVersion($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->version !== $v) {
            $this->version = $v;
            $this->modifiedColumns[TorrentMetadataTableMap::COL_VERSION] = true;
        }

        return $this;
    } // setVersion()

    /**
     * Set the value of [group] column.
     *
     * @param string $v new value
     * @return $this|\Odango\Hebi\Model\TorrentMetadata The current object (for fluent API support)
     */
    public function setGroup($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->group !== $v) {
            $this->group = $v;
            $this->modifiedColumns[TorrentMetadataTableMap::COL_GROUP] = true;
        }

        return $this;
    } // setGroup()

    /**
     * Set the value of [unparsed] column.
     *
     * @param array $v new value
     * @return $this|\Odango\Hebi\Model\TorrentMetadata The current object (for fluent API support)
     */
    public function setUnparsed($v)
    {
        if ($this->unparsed_unserialized !== $v) {
            $this->unparsed_unserialized = $v;
            $this->unparsed = '| ' . implode(' | ', $v) . ' |';
            $this->modifiedColumns[TorrentMetadataTableMap::COL_UNPARSED] = true;
        }

        return $this;
    } // setUnparsed()

    /**
     * Set the value of [resolution] column.
     *
     * @param string $v new value
     * @return $this|\Odango\Hebi\Model\TorrentMetadata The current object (for fluent API support)
     */
    public function setResolution($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->resolution !== $v) {
            $this->resolution = $v;
            $this->modifiedColumns[TorrentMetadataTableMap::COL_RESOLUTION] = true;
        }

        return $this;
    } // setResolution()

    /**
     * Set the value of [video] column.
     *
     * @param string $v new value
     * @return $this|\Odango\Hebi\Model\TorrentMetadata The current object (for fluent API support)
     */
    public function setVideo($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->video !== $v) {
            $this->video = $v;
            $this->modifiedColumns[TorrentMetadataTableMap::COL_VIDEO] = true;
        }

        return $this;
    } // setVideo()

    /**
     * Set the value of [video_depth] column.
     *
     * @param string $v new value
     * @return $this|\Odango\Hebi\Model\TorrentMetadata The current object (for fluent API support)
     */
    public function setVideoDepth($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->video_depth !== $v) {
            $this->video_depth = $v;
            $this->modifiedColumns[TorrentMetadataTableMap::COL_VIDEO_DEPTH] = true;
        }

        return $this;
    } // setVideoDepth()

    /**
     * Set the value of [audio] column.
     *
     * @param string $v new value
     * @return $this|\Odango\Hebi\Model\TorrentMetadata The current object (for fluent API support)
     */
    public function setAudio($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->audio !== $v) {
            $this->audio = $v;
            $this->modifiedColumns[TorrentMetadataTableMap::COL_AUDIO] = true;
        }

        return $this;
    } // setAudio()

    /**
     * Set the value of [source] column.
     *
     * @param string $v new value
     * @return $this|\Odango\Hebi\Model\TorrentMetadata The current object (for fluent API support)
     */
    public function setSource($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->source !== $v) {
            $this->source = $v;
            $this->modifiedColumns[TorrentMetadataTableMap::COL_SOURCE] = true;
        }

        return $this;
    } // setSource()

    /**
     * Set the value of [container] column.
     *
     * @param string $v new value
     * @return $this|\Odango\Hebi\Model\TorrentMetadata The current object (for fluent API support)
     */
    public function setContainer($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->container !== $v) {
            $this->container = $v;
            $this->modifiedColumns[TorrentMetadataTableMap::COL_CONTAINER] = true;
        }

        return $this;
    } // setContainer()

    /**
     * Set the value of [crc32] column.
     *
     * @param string $v new value
     * @return $this|\Odango\Hebi\Model\TorrentMetadata The current object (for fluent API support)
     */
    public function setCrc32($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->crc32 !== $v) {
            $this->crc32 = $v;
            $this->modifiedColumns[TorrentMetadataTableMap::COL_CRC32] = true;
        }

        return $this;
    } // setCrc32()

    /**
     * Set the value of [ep] column.
     *
     * @param array $v new value
     * @return $this|\Odango\Hebi\Model\TorrentMetadata The current object (for fluent API support)
     */
    public function setEp($v)
    {
        if ($this->ep_unserialized !== $v) {
            $this->ep_unserialized = $v;
            $this->ep = '| ' . implode(' | ', $v) . ' |';
            $this->modifiedColumns[TorrentMetadataTableMap::COL_EP] = true;
        }

        return $this;
    } // setEp()

    /**
     * Set the value of [special] column.
     *
     * @param string $v new value
     * @return $this|\Odango\Hebi\Model\TorrentMetadata The current object (for fluent API support)
     */
    public function setSpecial($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->special !== $v) {
            $this->special = $v;
            $this->modifiedColumns[TorrentMetadataTableMap::COL_SPECIAL] = true;
        }

        return $this;
    } // setSpecial()

    /**
     * Set the value of [season] column.
     *
     * @param string $v new value
     * @return $this|\Odango\Hebi\Model\TorrentMetadata The current object (for fluent API support)
     */
    public function setSeason($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->season !== $v) {
            $this->season = $v;
            $this->modifiedColumns[TorrentMetadataTableMap::COL_SEASON] = true;
        }

        return $this;
    } // setSeason()

    /**
     * Set the value of [volume] column.
     *
     * @param string $v new value
     * @return $this|\Odango\Hebi\Model\TorrentMetadata The current object (for fluent API support)
     */
    public function setVolume($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->volume !== $v) {
            $this->volume = $v;
            $this->modifiedColumns[TorrentMetadataTableMap::COL_VOLUME] = true;
        }

        return $this;
    } // setVolume()

    /**
     * Set the value of [collection] column.
     *
     * @param array $v new value
     * @return $this|\Odango\Hebi\Model\TorrentMetadata The current object (for fluent API support)
     */
    public function setCollection($v)
    {
        if ($this->collection_unserialized !== $v) {
            $this->collection_unserialized = $v;
            $this->collection = '| ' . implode(' | ', $v) . ' |';
            $this->modifiedColumns[TorrentMetadataTableMap::COL_COLLECTION] = true;
        }

        return $this;
    } // setCollection()

    /**
     * Sets the value of [date_created] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\Odango\Hebi\Model\TorrentMetadata The current object (for fluent API support)
     */
    public function setDateCreated($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->date_created !== null || $dt !== null) {
            if ($this->date_created === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->date_created->format("Y-m-d H:i:s.u")) {
                $this->date_created = $dt === null ? null : clone $dt;
                $this->modifiedColumns[TorrentMetadataTableMap::COL_DATE_CREATED] = true;
            }
        } // if either are not null

        return $this;
    } // setDateCreated()

    /**
     * Sets the value of [last_updated] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\Odango\Hebi\Model\TorrentMetadata The current object (for fluent API support)
     */
    public function setLastUpdated($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->last_updated !== null || $dt !== null) {
            if ($this->last_updated === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->last_updated->format("Y-m-d H:i:s.u")) {
                $this->last_updated = $dt === null ? null : clone $dt;
                $this->modifiedColumns[TorrentMetadataTableMap::COL_LAST_UPDATED] = true;
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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : TorrentMetadataTableMap::translateFieldName('TorrentId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->torrent_id = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : TorrentMetadataTableMap::translateFieldName('Name', TableMap::TYPE_PHPNAME, $indexType)];
            $this->name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : TorrentMetadataTableMap::translateFieldName('Type', TableMap::TYPE_PHPNAME, $indexType)];
            $this->type = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : TorrentMetadataTableMap::translateFieldName('Version', TableMap::TYPE_PHPNAME, $indexType)];
            $this->version = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : TorrentMetadataTableMap::translateFieldName('Group', TableMap::TYPE_PHPNAME, $indexType)];
            $this->group = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : TorrentMetadataTableMap::translateFieldName('Unparsed', TableMap::TYPE_PHPNAME, $indexType)];
            $this->unparsed = $col;
            $this->unparsed_unserialized = null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : TorrentMetadataTableMap::translateFieldName('Resolution', TableMap::TYPE_PHPNAME, $indexType)];
            $this->resolution = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : TorrentMetadataTableMap::translateFieldName('Video', TableMap::TYPE_PHPNAME, $indexType)];
            $this->video = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : TorrentMetadataTableMap::translateFieldName('VideoDepth', TableMap::TYPE_PHPNAME, $indexType)];
            $this->video_depth = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : TorrentMetadataTableMap::translateFieldName('Audio', TableMap::TYPE_PHPNAME, $indexType)];
            $this->audio = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 10 + $startcol : TorrentMetadataTableMap::translateFieldName('Source', TableMap::TYPE_PHPNAME, $indexType)];
            $this->source = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 11 + $startcol : TorrentMetadataTableMap::translateFieldName('Container', TableMap::TYPE_PHPNAME, $indexType)];
            $this->container = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 12 + $startcol : TorrentMetadataTableMap::translateFieldName('Crc32', TableMap::TYPE_PHPNAME, $indexType)];
            $this->crc32 = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 13 + $startcol : TorrentMetadataTableMap::translateFieldName('Ep', TableMap::TYPE_PHPNAME, $indexType)];
            $this->ep = $col;
            $this->ep_unserialized = null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 14 + $startcol : TorrentMetadataTableMap::translateFieldName('Special', TableMap::TYPE_PHPNAME, $indexType)];
            $this->special = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 15 + $startcol : TorrentMetadataTableMap::translateFieldName('Season', TableMap::TYPE_PHPNAME, $indexType)];
            $this->season = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 16 + $startcol : TorrentMetadataTableMap::translateFieldName('Volume', TableMap::TYPE_PHPNAME, $indexType)];
            $this->volume = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 17 + $startcol : TorrentMetadataTableMap::translateFieldName('Collection', TableMap::TYPE_PHPNAME, $indexType)];
            $this->collection = $col;
            $this->collection_unserialized = null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 18 + $startcol : TorrentMetadataTableMap::translateFieldName('DateCreated', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->date_created = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 19 + $startcol : TorrentMetadataTableMap::translateFieldName('LastUpdated', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->last_updated = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 20; // 20 = TorrentMetadataTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Odango\\Hebi\\Model\\TorrentMetadata'), 0, $e);
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
        if ($this->aTorrent !== null && $this->torrent_id !== $this->aTorrent->getId()) {
            $this->aTorrent = null;
        }
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
            $con = Propel::getServiceContainer()->getReadConnection(TorrentMetadataTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildTorrentMetadataQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aTorrent = null;
        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see TorrentMetadata::setDeleted()
     * @see TorrentMetadata::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(TorrentMetadataTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildTorrentMetadataQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(TorrentMetadataTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $ret = $this->preSave($con);
            $isInsert = $this->isNew();
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
                // timestampable behavior

                if (!$this->isColumnModified(TorrentMetadataTableMap::COL_DATE_CREATED)) {
                    $this->setDateCreated(\Propel\Runtime\Util\PropelDateTime::createHighPrecision());
                }
                if (!$this->isColumnModified(TorrentMetadataTableMap::COL_LAST_UPDATED)) {
                    $this->setLastUpdated(\Propel\Runtime\Util\PropelDateTime::createHighPrecision());
                }
            } else {
                $ret = $ret && $this->preUpdate($con);
                // timestampable behavior
                if ($this->isModified() && !$this->isColumnModified(TorrentMetadataTableMap::COL_LAST_UPDATED)) {
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
                TorrentMetadataTableMap::addInstanceToPool($this);
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

            // We call the save method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aTorrent !== null) {
                if ($this->aTorrent->isModified() || $this->aTorrent->isNew()) {
                    $affectedRows += $this->aTorrent->save($con);
                }
                $this->setTorrent($this->aTorrent);
            }

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
        if ($this->isColumnModified(TorrentMetadataTableMap::COL_TORRENT_ID)) {
            $modifiedColumns[':p' . $index++]  = '`torrent_id`';
        }
        if ($this->isColumnModified(TorrentMetadataTableMap::COL_NAME)) {
            $modifiedColumns[':p' . $index++]  = '`name`';
        }
        if ($this->isColumnModified(TorrentMetadataTableMap::COL_TYPE)) {
            $modifiedColumns[':p' . $index++]  = '`type`';
        }
        if ($this->isColumnModified(TorrentMetadataTableMap::COL_VERSION)) {
            $modifiedColumns[':p' . $index++]  = '`version`';
        }
        if ($this->isColumnModified(TorrentMetadataTableMap::COL_GROUP)) {
            $modifiedColumns[':p' . $index++]  = '`group`';
        }
        if ($this->isColumnModified(TorrentMetadataTableMap::COL_UNPARSED)) {
            $modifiedColumns[':p' . $index++]  = '`unparsed`';
        }
        if ($this->isColumnModified(TorrentMetadataTableMap::COL_RESOLUTION)) {
            $modifiedColumns[':p' . $index++]  = '`resolution`';
        }
        if ($this->isColumnModified(TorrentMetadataTableMap::COL_VIDEO)) {
            $modifiedColumns[':p' . $index++]  = '`video`';
        }
        if ($this->isColumnModified(TorrentMetadataTableMap::COL_VIDEO_DEPTH)) {
            $modifiedColumns[':p' . $index++]  = '`video_depth`';
        }
        if ($this->isColumnModified(TorrentMetadataTableMap::COL_AUDIO)) {
            $modifiedColumns[':p' . $index++]  = '`audio`';
        }
        if ($this->isColumnModified(TorrentMetadataTableMap::COL_SOURCE)) {
            $modifiedColumns[':p' . $index++]  = '`source`';
        }
        if ($this->isColumnModified(TorrentMetadataTableMap::COL_CONTAINER)) {
            $modifiedColumns[':p' . $index++]  = '`container`';
        }
        if ($this->isColumnModified(TorrentMetadataTableMap::COL_CRC32)) {
            $modifiedColumns[':p' . $index++]  = '`crc32`';
        }
        if ($this->isColumnModified(TorrentMetadataTableMap::COL_EP)) {
            $modifiedColumns[':p' . $index++]  = '`ep`';
        }
        if ($this->isColumnModified(TorrentMetadataTableMap::COL_SPECIAL)) {
            $modifiedColumns[':p' . $index++]  = '`special`';
        }
        if ($this->isColumnModified(TorrentMetadataTableMap::COL_SEASON)) {
            $modifiedColumns[':p' . $index++]  = '`season`';
        }
        if ($this->isColumnModified(TorrentMetadataTableMap::COL_VOLUME)) {
            $modifiedColumns[':p' . $index++]  = '`volume`';
        }
        if ($this->isColumnModified(TorrentMetadataTableMap::COL_COLLECTION)) {
            $modifiedColumns[':p' . $index++]  = '`collection`';
        }
        if ($this->isColumnModified(TorrentMetadataTableMap::COL_DATE_CREATED)) {
            $modifiedColumns[':p' . $index++]  = '`date_created`';
        }
        if ($this->isColumnModified(TorrentMetadataTableMap::COL_LAST_UPDATED)) {
            $modifiedColumns[':p' . $index++]  = '`last_updated`';
        }

        $sql = sprintf(
            'INSERT INTO `torrent_metadata` (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case '`torrent_id`':
                        $stmt->bindValue($identifier, $this->torrent_id, PDO::PARAM_INT);
                        break;
                    case '`name`':
                        $stmt->bindValue($identifier, $this->name, PDO::PARAM_STR);
                        break;
                    case '`type`':
                        $stmt->bindValue($identifier, $this->type, PDO::PARAM_STR);
                        break;
                    case '`version`':
                        $stmt->bindValue($identifier, $this->version, PDO::PARAM_STR);
                        break;
                    case '`group`':
                        $stmt->bindValue($identifier, $this->group, PDO::PARAM_STR);
                        break;
                    case '`unparsed`':
                        $stmt->bindValue($identifier, $this->unparsed, PDO::PARAM_STR);
                        break;
                    case '`resolution`':
                        $stmt->bindValue($identifier, $this->resolution, PDO::PARAM_STR);
                        break;
                    case '`video`':
                        $stmt->bindValue($identifier, $this->video, PDO::PARAM_STR);
                        break;
                    case '`video_depth`':
                        $stmt->bindValue($identifier, $this->video_depth, PDO::PARAM_STR);
                        break;
                    case '`audio`':
                        $stmt->bindValue($identifier, $this->audio, PDO::PARAM_STR);
                        break;
                    case '`source`':
                        $stmt->bindValue($identifier, $this->source, PDO::PARAM_STR);
                        break;
                    case '`container`':
                        $stmt->bindValue($identifier, $this->container, PDO::PARAM_STR);
                        break;
                    case '`crc32`':
                        $stmt->bindValue($identifier, $this->crc32, PDO::PARAM_STR);
                        break;
                    case '`ep`':
                        $stmt->bindValue($identifier, $this->ep, PDO::PARAM_STR);
                        break;
                    case '`special`':
                        $stmt->bindValue($identifier, $this->special, PDO::PARAM_STR);
                        break;
                    case '`season`':
                        $stmt->bindValue($identifier, $this->season, PDO::PARAM_INT);
                        break;
                    case '`volume`':
                        $stmt->bindValue($identifier, $this->volume, PDO::PARAM_STR);
                        break;
                    case '`collection`':
                        $stmt->bindValue($identifier, $this->collection, PDO::PARAM_STR);
                        break;
                    case '`date_created`':
                        $stmt->bindValue($identifier, $this->date_created ? $this->date_created->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
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
        $pos = TorrentMetadataTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getTorrentId();
                break;
            case 1:
                return $this->getName();
                break;
            case 2:
                return $this->getType();
                break;
            case 3:
                return $this->getVersion();
                break;
            case 4:
                return $this->getGroup();
                break;
            case 5:
                return $this->getUnparsed();
                break;
            case 6:
                return $this->getResolution();
                break;
            case 7:
                return $this->getVideo();
                break;
            case 8:
                return $this->getVideoDepth();
                break;
            case 9:
                return $this->getAudio();
                break;
            case 10:
                return $this->getSource();
                break;
            case 11:
                return $this->getContainer();
                break;
            case 12:
                return $this->getCrc32();
                break;
            case 13:
                return $this->getEp();
                break;
            case 14:
                return $this->getSpecial();
                break;
            case 15:
                return $this->getSeason();
                break;
            case 16:
                return $this->getVolume();
                break;
            case 17:
                return $this->getCollection();
                break;
            case 18:
                return $this->getDateCreated();
                break;
            case 19:
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

        if (isset($alreadyDumpedObjects['TorrentMetadata'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['TorrentMetadata'][$this->hashCode()] = true;
        $keys = TorrentMetadataTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getTorrentId(),
            $keys[1] => $this->getName(),
            $keys[2] => $this->getType(),
            $keys[3] => $this->getVersion(),
            $keys[4] => $this->getGroup(),
            $keys[5] => $this->getUnparsed(),
            $keys[6] => $this->getResolution(),
            $keys[7] => $this->getVideo(),
            $keys[8] => $this->getVideoDepth(),
            $keys[9] => $this->getAudio(),
            $keys[10] => $this->getSource(),
            $keys[11] => $this->getContainer(),
            $keys[12] => $this->getCrc32(),
            $keys[13] => $this->getEp(),
            $keys[14] => $this->getSpecial(),
            $keys[15] => $this->getSeason(),
            $keys[16] => $this->getVolume(),
            $keys[17] => $this->getCollection(),
            $keys[18] => $this->getDateCreated(),
            $keys[19] => $this->getLastUpdated(),
        );
        if ($result[$keys[18]] instanceof \DateTime) {
            $result[$keys[18]] = $result[$keys[18]]->format('c');
        }

        if ($result[$keys[19]] instanceof \DateTime) {
            $result[$keys[19]] = $result[$keys[19]]->format('c');
        }

        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aTorrent) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'torrent';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'torrent';
                        break;
                    default:
                        $key = 'Torrent';
                }

                $result[$key] = $this->aTorrent->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
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
     * @return $this|\Odango\Hebi\Model\TorrentMetadata
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = TorrentMetadataTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Odango\Hebi\Model\TorrentMetadata
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setTorrentId($value);
                break;
            case 1:
                $this->setName($value);
                break;
            case 2:
                $this->setType($value);
                break;
            case 3:
                $this->setVersion($value);
                break;
            case 4:
                $this->setGroup($value);
                break;
            case 5:
                if (!is_array($value)) {
                    $v = trim(substr($value, 2, -2));
                    $value = $v ? explode(' | ', $v) : array();
                }
                $this->setUnparsed($value);
                break;
            case 6:
                $this->setResolution($value);
                break;
            case 7:
                $this->setVideo($value);
                break;
            case 8:
                $this->setVideoDepth($value);
                break;
            case 9:
                $this->setAudio($value);
                break;
            case 10:
                $this->setSource($value);
                break;
            case 11:
                $this->setContainer($value);
                break;
            case 12:
                $this->setCrc32($value);
                break;
            case 13:
                if (!is_array($value)) {
                    $v = trim(substr($value, 2, -2));
                    $value = $v ? explode(' | ', $v) : array();
                }
                $this->setEp($value);
                break;
            case 14:
                $this->setSpecial($value);
                break;
            case 15:
                $this->setSeason($value);
                break;
            case 16:
                $this->setVolume($value);
                break;
            case 17:
                if (!is_array($value)) {
                    $v = trim(substr($value, 2, -2));
                    $value = $v ? explode(' | ', $v) : array();
                }
                $this->setCollection($value);
                break;
            case 18:
                $this->setDateCreated($value);
                break;
            case 19:
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
        $keys = TorrentMetadataTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setTorrentId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setName($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setType($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setVersion($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setGroup($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setUnparsed($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setResolution($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setVideo($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setVideoDepth($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setAudio($arr[$keys[9]]);
        }
        if (array_key_exists($keys[10], $arr)) {
            $this->setSource($arr[$keys[10]]);
        }
        if (array_key_exists($keys[11], $arr)) {
            $this->setContainer($arr[$keys[11]]);
        }
        if (array_key_exists($keys[12], $arr)) {
            $this->setCrc32($arr[$keys[12]]);
        }
        if (array_key_exists($keys[13], $arr)) {
            $this->setEp($arr[$keys[13]]);
        }
        if (array_key_exists($keys[14], $arr)) {
            $this->setSpecial($arr[$keys[14]]);
        }
        if (array_key_exists($keys[15], $arr)) {
            $this->setSeason($arr[$keys[15]]);
        }
        if (array_key_exists($keys[16], $arr)) {
            $this->setVolume($arr[$keys[16]]);
        }
        if (array_key_exists($keys[17], $arr)) {
            $this->setCollection($arr[$keys[17]]);
        }
        if (array_key_exists($keys[18], $arr)) {
            $this->setDateCreated($arr[$keys[18]]);
        }
        if (array_key_exists($keys[19], $arr)) {
            $this->setLastUpdated($arr[$keys[19]]);
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
     * @return $this|\Odango\Hebi\Model\TorrentMetadata The current object, for fluid interface
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
        $criteria = new Criteria(TorrentMetadataTableMap::DATABASE_NAME);

        if ($this->isColumnModified(TorrentMetadataTableMap::COL_TORRENT_ID)) {
            $criteria->add(TorrentMetadataTableMap::COL_TORRENT_ID, $this->torrent_id);
        }
        if ($this->isColumnModified(TorrentMetadataTableMap::COL_NAME)) {
            $criteria->add(TorrentMetadataTableMap::COL_NAME, $this->name);
        }
        if ($this->isColumnModified(TorrentMetadataTableMap::COL_TYPE)) {
            $criteria->add(TorrentMetadataTableMap::COL_TYPE, $this->type);
        }
        if ($this->isColumnModified(TorrentMetadataTableMap::COL_VERSION)) {
            $criteria->add(TorrentMetadataTableMap::COL_VERSION, $this->version);
        }
        if ($this->isColumnModified(TorrentMetadataTableMap::COL_GROUP)) {
            $criteria->add(TorrentMetadataTableMap::COL_GROUP, $this->group);
        }
        if ($this->isColumnModified(TorrentMetadataTableMap::COL_UNPARSED)) {
            $criteria->add(TorrentMetadataTableMap::COL_UNPARSED, $this->unparsed);
        }
        if ($this->isColumnModified(TorrentMetadataTableMap::COL_RESOLUTION)) {
            $criteria->add(TorrentMetadataTableMap::COL_RESOLUTION, $this->resolution);
        }
        if ($this->isColumnModified(TorrentMetadataTableMap::COL_VIDEO)) {
            $criteria->add(TorrentMetadataTableMap::COL_VIDEO, $this->video);
        }
        if ($this->isColumnModified(TorrentMetadataTableMap::COL_VIDEO_DEPTH)) {
            $criteria->add(TorrentMetadataTableMap::COL_VIDEO_DEPTH, $this->video_depth);
        }
        if ($this->isColumnModified(TorrentMetadataTableMap::COL_AUDIO)) {
            $criteria->add(TorrentMetadataTableMap::COL_AUDIO, $this->audio);
        }
        if ($this->isColumnModified(TorrentMetadataTableMap::COL_SOURCE)) {
            $criteria->add(TorrentMetadataTableMap::COL_SOURCE, $this->source);
        }
        if ($this->isColumnModified(TorrentMetadataTableMap::COL_CONTAINER)) {
            $criteria->add(TorrentMetadataTableMap::COL_CONTAINER, $this->container);
        }
        if ($this->isColumnModified(TorrentMetadataTableMap::COL_CRC32)) {
            $criteria->add(TorrentMetadataTableMap::COL_CRC32, $this->crc32);
        }
        if ($this->isColumnModified(TorrentMetadataTableMap::COL_EP)) {
            $criteria->add(TorrentMetadataTableMap::COL_EP, $this->ep);
        }
        if ($this->isColumnModified(TorrentMetadataTableMap::COL_SPECIAL)) {
            $criteria->add(TorrentMetadataTableMap::COL_SPECIAL, $this->special);
        }
        if ($this->isColumnModified(TorrentMetadataTableMap::COL_SEASON)) {
            $criteria->add(TorrentMetadataTableMap::COL_SEASON, $this->season);
        }
        if ($this->isColumnModified(TorrentMetadataTableMap::COL_VOLUME)) {
            $criteria->add(TorrentMetadataTableMap::COL_VOLUME, $this->volume);
        }
        if ($this->isColumnModified(TorrentMetadataTableMap::COL_COLLECTION)) {
            $criteria->add(TorrentMetadataTableMap::COL_COLLECTION, $this->collection);
        }
        if ($this->isColumnModified(TorrentMetadataTableMap::COL_DATE_CREATED)) {
            $criteria->add(TorrentMetadataTableMap::COL_DATE_CREATED, $this->date_created);
        }
        if ($this->isColumnModified(TorrentMetadataTableMap::COL_LAST_UPDATED)) {
            $criteria->add(TorrentMetadataTableMap::COL_LAST_UPDATED, $this->last_updated);
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
        $criteria = ChildTorrentMetadataQuery::create();
        $criteria->add(TorrentMetadataTableMap::COL_TORRENT_ID, $this->torrent_id);

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
        $validPk = null !== $this->getTorrentId();

        $validPrimaryKeyFKs = 1;
        $primaryKeyFKs = [];

        //relation torrent_metadata_fk_693b7d to table torrent
        if ($this->aTorrent && $hash = spl_object_hash($this->aTorrent)) {
            $primaryKeyFKs[] = $hash;
        } else {
            $validPrimaryKeyFKs = false;
        }

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
        return $this->getTorrentId();
    }

    /**
     * Generic method to set the primary key (torrent_id column).
     *
     * @param       string $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setTorrentId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getTorrentId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \Odango\Hebi\Model\TorrentMetadata (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setTorrentId($this->getTorrentId());
        $copyObj->setName($this->getName());
        $copyObj->setType($this->getType());
        $copyObj->setVersion($this->getVersion());
        $copyObj->setGroup($this->getGroup());
        $copyObj->setUnparsed($this->getUnparsed());
        $copyObj->setResolution($this->getResolution());
        $copyObj->setVideo($this->getVideo());
        $copyObj->setVideoDepth($this->getVideoDepth());
        $copyObj->setAudio($this->getAudio());
        $copyObj->setSource($this->getSource());
        $copyObj->setContainer($this->getContainer());
        $copyObj->setCrc32($this->getCrc32());
        $copyObj->setEp($this->getEp());
        $copyObj->setSpecial($this->getSpecial());
        $copyObj->setSeason($this->getSeason());
        $copyObj->setVolume($this->getVolume());
        $copyObj->setCollection($this->getCollection());
        $copyObj->setDateCreated($this->getDateCreated());
        $copyObj->setLastUpdated($this->getLastUpdated());
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
     * @return \Odango\Hebi\Model\TorrentMetadata Clone of current object.
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
     * Declares an association between this object and a ChildTorrent object.
     *
     * @param  ChildTorrent $v
     * @return $this|\Odango\Hebi\Model\TorrentMetadata The current object (for fluent API support)
     * @throws PropelException
     */
    public function setTorrent(ChildTorrent $v = null)
    {
        if ($v === null) {
            $this->setTorrentId(NULL);
        } else {
            $this->setTorrentId($v->getId());
        }

        $this->aTorrent = $v;

        // Add binding for other direction of this 1:1 relationship.
        if ($v !== null) {
            $v->setTorrentMetadata($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildTorrent object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildTorrent The associated ChildTorrent object.
     * @throws PropelException
     */
    public function getTorrent(ConnectionInterface $con = null)
    {
        if ($this->aTorrent === null && (($this->torrent_id !== "" && $this->torrent_id !== null))) {
            $this->aTorrent = ChildTorrentQuery::create()->findPk($this->torrent_id, $con);
            // Because this foreign key represents a one-to-one relationship, we will create a bi-directional association.
            $this->aTorrent->setTorrentMetadata($this);
        }

        return $this->aTorrent;
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aTorrent) {
            $this->aTorrent->removeTorrentMetadata($this);
        }
        $this->torrent_id = null;
        $this->name = null;
        $this->type = null;
        $this->version = null;
        $this->group = null;
        $this->unparsed = null;
        $this->unparsed_unserialized = null;
        $this->resolution = null;
        $this->video = null;
        $this->video_depth = null;
        $this->audio = null;
        $this->source = null;
        $this->container = null;
        $this->crc32 = null;
        $this->ep = null;
        $this->ep_unserialized = null;
        $this->special = null;
        $this->season = null;
        $this->volume = null;
        $this->collection = null;
        $this->collection_unserialized = null;
        $this->date_created = null;
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
        } // if ($deep)

        $this->aTorrent = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(TorrentMetadataTableMap::DEFAULT_STRING_FORMAT);
    }

    // timestampable behavior

    /**
     * Mark the current object so that the update date doesn't get updated during next save
     *
     * @return     $this|ChildTorrentMetadata The current object (for fluent API support)
     */
    public function keepUpdateDateUnchanged()
    {
        $this->modifiedColumns[TorrentMetadataTableMap::COL_LAST_UPDATED] = true;

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
