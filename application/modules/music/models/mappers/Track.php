<?php

/**
 * Description of Music_Model_Mapper_Track
 *
 * @author John Schoenwolf
 */
class Music_Model_Mapper_Track extends Jgs_Model_Mapper_Abstract
{
    /**
     * Name of database table as a string.
     *
     * @var string $_tableName
     */
    protected $tableName   = 'track';
    /**
     * Name of entity model class as a string.
     *
     * @var string $_entityClass
     */
    protected $entityClass = 'Music_Model_Track';
    /**
     * instance of artistMapper object
     *
     * @var object $_artistMapper
     */
    protected $artistMapper;
    /**
     * instance of albumMapper Object
     *
     * @var object $_albumMapper
     */
    protected $albumMapper;

    /**
     * accepts instance of Zend_Db_Table_Abstract or a string for database
     * table name.
     *
     * @param Zend_Db_Table_Abstract $tableGateway
     */
    public function __construct(Zend_Db_Table_Abstract $tableGateway = null)
    {
        $tableGateway = new Application_Model_DbTable_Track();
        parent::__construct($tableGateway);
    }

    /**
     * Creates concrete object of Music_Model_Track
     *
     * @param object $row
     * @return \Music_Model_Track
     */
    public function createEntity($row)
    {

        $data = array(
            'id'           => $row->id,
            'filename'     => $row->filename,
            'format'       => $row->format,
            'genre'        => $row->genre,
            'hash'         => $row->hash,
            'path'         => $row->path,
            'playtime'     => $row->playtime,
            'title'        => $row->title,
            'track_number' => $row->track_number,
            'album'        => $row->album_id,
            'artist'       => $row->artist_id
        );

        return new Music_Model_Track($data);
    }

    /**
     * Insert or update track database table
     *
     * @param Music_Model_Track $track
     * @return object
     */
    public function saveTrack(Music_Model_Track $track)
    {

        if(!is_null($track->id) && !is_null($this->findById($track->id))) {
            $select = $this->getGateway()->select();
            $select->where('id = ?', $track->id);
            $row    = $this->getGateway()->fetchRow($select);
        } else {
            $row = $this->getGateway()->createRow();
        }

        $row->album_id     = $track->album->id;
        $row->artist_id    = $track->artist->id;
        $row->filename     = $track->filename;
        $row->format       = $track->format;
        $row->genre        = $track->genre;
        $row->hash         = $track->hash;
        $row->path         = $track->path;
        $row->playtime     = $track->playtime;
        $row->title        = $track->title;
        $row->track_number = $track->track_number;

        $row->save();
        return $row;
    }

    /**
     * Creates Zend_Paginator_Adapter_DbTableSelect object,
     * based on artist_id or query string.
     *
     * @param string $id
     * @param string $query
     * @return Music_Model_Paginator_Track
     */
    public function fetchPagedTracks($id = null, $query = null)
    {

        if(!is_null($id)) {
            $select = $this->getGateway()->select();
            $select->where('track.artist_id = ?', $id);
        }
        if(!is_null($query)) {
            $select = $this->getGateway()
                ->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
            $select->setIntegrityCheck(false);
            $select->join('artist', 'artist.id = track.artist_id');
            $select->where("track.title LIKE '%$query%'");
            $select->orWhere("artist.name LIKE '%$query%'");
        }
        $select->order('track.artist_id ASC');
        $select->order('track.album_id ASC');
        $select->order('track.track_number ASC');

        $adapter = new Music_Model_Paginator_Track($select);

        return $adapter;
    }

    /**
     * Return specific paginator adapter
     *
     * @param string $column
     * @param string $value
     * @return \Music_Model_Paginator_Track
     */
    public function findByIdPaged($column, $value)
    {
        $select  = $this->getGateway()->select();
        $select->where("$column = ?", $value);
        //assign select() to object specific paginator adapter
        $adapter = new Music_Model_Paginator_Track($select);

        return $adapter;
    }

    /**
     * accepts a string, an array of id's or an instance or array of
     * instances of Music_Model_track
     *
     * @param array|string|Music_Model_Track $track
     */
    public function deleteTrack($track)
    {

        if($track instanceof Music_Model_Track) {
            $where = $this->getGateway()->getAdapter()
                ->quoteInto('id = ?', $track->id);
        } else {
            $where = $this->getGateway()->getAdapter()
                ->quoteInto('id = ?', $track);
        }
        $this->getGateway()->delete($where);
    }
}
