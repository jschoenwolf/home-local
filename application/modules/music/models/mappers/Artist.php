<?php

/**
 * Description of Artist
 *
 * @author John Schoenwolf
 */
class Music_Model_Mapper_Artist extends Jgs_Application_Model_Mapper
{
    protected $_tableName = 'artist';


    public function __construct(Zend_Db_Table_Abstract $tableGateway = NULL) {
        $this->_tableGateway = new Application_Model_DbTable_Artist();
        parent::__construct($tableGateway);
    }

    /**
     * Creates concrete object of Music_Model_Artist
     *
     * @param object $row
     * @return Music_Model_Artist
     */
    public function createEntity($row) {

        $artist = new Music_Model_Artist($row->id,$row->name);

        return $artist;
    }

    /**
     * Insert or update album database table
     *
     * @param Music_Model_Artist $artist
     * @return object
     */
    public function saveTrack(Music_Model_Artist $artist) {

        if (!is_null($artist->id) && !is_null($this->findById($artist->id))) {
            $row = $this->findById($artist->id);
            $row->id = $artist->id;
        } else {
            $row = $this->_getGateway()->createRow();
        }
        $row->name = $artist->name;

        $row->save();
        return $row;
    }

    /**
     * Creates Zend_Paginator_Adapter_DbTableSelect object
     *
     * @return Music_Model_Paginator_Artist
     */
    public function fetchAllPaged() {

        $select = $this->_getGateway()->select();
        $select->order('name', 'ASC');

        $adapter = new Music_Model_Paginator_Artist($select);

        return $adapter;
    }
    
    public function findByColumnPaged($column, $value) {
        $select = $this->_getGateway()->select();
        $select->where("$column LIKE '%$value%'");
        $select->order('name ASC');
        
        $adapter = new Music_Model_Paginator_Artist($select);

        return $adapter;
    }

    /**
     * accepts a string, an array of id's or an instance or array of
     * instances of Music_Model_track
     *
     * @param array|string|Music_Model_Track $artist
     */
    public function deleteTrack($artist) {
        if ($artist instanceof Music_Model_Artist) {
            $where = $this->_getGateway()->getAdapter()
                          ->quoteInto('id = ?', $artist->id);
        } elseif (is_array($artist)) {
            foreach ($artist as $id) {
                if (is_object($id)) {
                    $where = $this->_getGateway()->getAdapter()
                                  ->quoteInto('id = ?', $id->id);
                }
                $where = $this->_getGateway()->getAdapter()
                              ->quoteInto('id = ?', $id);
            }
        } else {
            $where = $this->_getGateway()->getAdapter()
                          ->quoteInto('id = ?', $artist);
        }
        $this->_getGateway()->delete($where);
    }

    

}
