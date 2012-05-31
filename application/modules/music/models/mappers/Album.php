<?php

/**
 * Description of Album
 *
 * @author John Schoenwolf
 */
class Music_Model_Mapper_Album extends Jgs_Application_Model_Mapper
{
    protected $_tableName = 'album';

    public function __construct(Zend_Db_Table_Abstract $tableGateway = NULL) {
        $tableGateway = new Application_Model_DbTable_Album();
        parent::__construct($tableGateway);
    }

    /**
     * Creates concrete object of Music_Model_Artist
     *
     * @param object $row
     * @return Music_Model_Album
     */
    public function createEntity($row) {

        $data = array(
            'id'     => $row->id,
            'name'   => $row->name,
            'art'    => $row->art,
            'year'   => $row->year,
            'artist' => $row->artist_id,
        );

        return new Music_Model_Album($data);
    }

     /**
     * Insert or update album database table
     *
     * @param Music_Model_Album $album
     * @return object
     */
    public function saveAlbum(Music_Model_Album $album) {

        if (!is_null($album->id) && !is_null($this->findById($album->id))) {
            $select = $this->_getGateway()->select();
            $select->where('id = ?', $album->id);
            $row = $this->_getGateway()->fetchRow($select);
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

    public function findByIdPaged($column, $value) {
        $select = $this->_getGateway()->select();
        $select->where("$column = ?", $value);

        $adapter = new Music_Model_Paginator_Album($select);

        return $adapter;
    }

    /**
     * accepts a string, an array of id's or an instance or array of
     * instances of Music_Model_track
     *
     * @param array|string|Music_Model_Track $album
     */
    public function deleteAlbum($album) {
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
