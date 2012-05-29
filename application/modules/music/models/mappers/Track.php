<?php

/**
 * Description of Music_Model_Mapper_Track
 *
 * @author John Schoenwolf
 */
class Music_Model_Mapper_Track extends Jgs_Application_Model_Mapper
{
   /**
     * Name of database table as a string.
     *
     * @var string $_tableName
     */
    protected $_tableName = 'track';
    /**
     * Name of entity model class as a string.
     *
     * @var string $_entityClass
     */
    protected $_entityClass = 'Music_Model_Track';
    /**
     * instance of artistMapper object
     *
     * @var object $_artistMapper
     */
    protected $_artistMapper;
    /**
     * instance of albumMapper Object
     *
     * @var object $_albumMapper
     */
    protected $_albumMapper;

    /**
     * accepts instance of Zend_Db_Table_Abstract or a string for database
     * table name.
     *
     * @param Zend_Db_Table_Abstract $tableGateway
     */
    public function __construct(Zend_Db_Table_Abstract $tableGateway = NULL) {
        $tableGateway = new Application_Model_DbTable_Track();
        parent::__construct($tableGateway);
    }

    /**
     * Creates concrete object of Music_Model_Track
     *
     * @param object $row
     * @return \Music_Model_Track
     */
    public function createEntity($row) {

        $data = array(
            'id'        => $row->id,
            'filename'  => $row->filename,
            'format'    => $row->format,
            'genre'     => $row->genre,
            'hash'      => $row->hash,
            'path'      => $row->path,
            'play_time' => $row->play_time,
            'title'     => $row->title,
            'track'     => $row->track,
            'album'     => $row->album_id,
            'artist'    => $row->artist_id
        );

        return new Music_Model_Track($data);
    }

    /**
     * Insert or update track database table
     *
     * @param Music_Model_Track $track
     * @return object
     */
    public function saveTrack(Music_Model_Track $track) {

        if (!is_null($track->id) && !is_null($this->findById($track->id))) {
            $select = $this->_getGateway()->select();
            $select->where('id = ?', $track->id);
            $row = $this->_getGateway()->fetchRow($select);
        } else {
            $row = $this->_getGateway()->createRow();
        }
        $row->album_id  = $track->album->id;
        $row->artist_id = $track->artist->id;
        $row->filename  = $track->filename;
        $row->format    = $track->format;
        $row->genre     = $track->genre;
        $row->hash      = $track->hash;
        $row->path      = $track->path;
        $row->play_time = $track->play_time;
        $row->title     = $track->title;
        $row->track     = $track->track;

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
    public function fetchPagedTracks($id = NULL, $query = NULL) {

        if (!is_null($id)) {
            $select = $this->_getGateway()->select();
            $select->where('track.artist_id = ?', $id);
        }
        if (!is_null($query)) {
            $select = $this->_getGateway()
                    ->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
            $select->setIntegrityCheck(FALSE);
            $select->join('artist', 'artist.id = track.artist_id');
            $select->where("track.title LIKE '%$query%'");
            $select->orWhere("artist.name LIKE '%$query%'");
        }
        $select->order('track.artist_id ASC');
        $select->order('track.album_id ASC');
        $select->order('track.track ASC');

        $adapter = new Music_Model_Paginator_Track($select);

        return $adapter;
    }

    public function findByIdPaged($column, $value) {
        $select = $this->_getGateway()->select();
        $select->where("$column = ?", $value);
        //assign select object to object specific paginator adapter
        $adapter = new Music_Model_Paginator_Track($select);

        return $adapter;
    }

    /**
     * accepts a string, an array of id's or an instance or array of
     * instances of Music_Model_track
     *
     * @param array|string|Music_Model_Track $track
     */
    public function deleteTrack($track) {
        if ($track instanceof Music_Model_Track) {
            $where = $this->_getGateway()->getAdapter()
                          ->quoteInto('id = ?', $track->id);
        } elseif (is_array($track)) {
            foreach ($track as $id) {
                if (is_object($id)) {
                    $where = $this->_getGateway()->getAdapter()
                                  ->quoteInto('id = ?', $id->id);
                }
                $where = $this->_getGateway()->getAdapter()
                              ->quoteInto('id = ?', $id);
            }
        } else {
            $where = $this->_getGateway()->getAdapter()
                          ->quoteInto('id = ?', $track);
        }
        $this->_getGateway()->delete($where);
    }
}
