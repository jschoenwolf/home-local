<?php

/**
 * Description of Album
 *
 * @author John Schoenwolf
 */
class Music_Model_Mapper_Album extends Jgs_Application_Model_Mapper
{
    protected $_tableName = 'album';
    protected $_artistMapper;

    public function __construct(Zend_Db_Table_Abstract $tableGateway = NULL) {
        $this->_tableGateway = new Application_Model_DbTable_Album();
        $this->_artistMapper = new Music_Model_Mapper_Artist();

        parent::__construct($tableGateway);
    }

    /**
     * Creates concrete object of Music_Model_Artist
     *
     * @param object $row
     * @return Music_Model_Album
     */
    public function createEntity($row) {

        $artist = $this->_artistMapper->findById($row->artist_id);

        $data = array(
            'id'     => $row->id,
            'name'   => $row->name,
            'art'    => $row->art,
            'year'   => $row->year,
            'artist' => $artist,
        );
        $album = new Music_Model_Album($data);

        return $album;
    }

     /**
     * Insert or update album database table
     *
     * @param Music_Model_Album $album
     * @return object
     */
    public function saveTrack(Music_Model_Album $album) {

        if (!is_null($album->id) && !is_null($this->findById($album->id))) {
            $row = $this->findById($album->id);
            $row->id = $album->id;
        } else {
            $row = $this->_getGateway()->createRow();
        }
        $row->name      = $album->name;
        $row->art       = $album->art;
        $row->year      = $album->year;
        $row->artist_id = $album->artist->id;

        $row->save();
        return $row;
    }

    /**
     * accepts a string, an array of id's or an instance or array of
     * instances of Music_Model_track
     *
     * @param array|string|Music_Model_Track $album
     */
    public function deleteTrack($album) {
        if ($album instanceof Music_Model_Album) {
            $where = $this->_getGateway()->getAdapter()
                          ->quoteInto('id = ?', $album->id);
        } elseif (is_array($album)) {
            foreach ($album as $id) {
                if (is_object($id)) {
                    $where = $this->_getGateway()->getAdapter()
                                  ->quoteInto('id = ?', $id->id);
                }
                $where = $this->_getGateway()->getAdapter()
                              ->quoteInto('id = ?', $id);
            }
        } else {
            $where = $this->_getGateway()->getAdapter()
                          ->quoteInto('id = ?', $album);
        }
        $this->_getGateway()->delete($where);
    }


}
