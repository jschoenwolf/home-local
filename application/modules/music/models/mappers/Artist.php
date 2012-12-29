<?php

/**
 * Description of Artist
 *
 * @author John Schoenwolf
 */
class Music_Model_Mapper_Artist extends Jgs_Model_Mapper_Abstract
{
    protected $tableName = 'artist';

    public function __construct(Zend_Db_Table_Abstract $tableGateway = null)
    {
        $tableGateway = new Application_Model_DbTable_Artist();
        parent::__construct($tableGateway);
    }

    /**
     * Creates concrete object of Music_Model_Artist
     *
     * @param object $row
     * @return Music_Model_Artist
     */
    public function createEntity($row)
    {

        $data = array(
            'id'    => $row->id,
            'name'  => $row->name
        );
        $artist = new Music_Model_Artist($data);

        return $artist;
    }

    /**
     * Insert or update album database table
     *
     * @param Music_Model_Artist $artist
     * @return object
     */
    public function saveArtist(Music_Model_Artist $artist)
    {

        if (!is_null($artist->id) && !is_null($this->findById($artist->id))) {
            $select = $this->getGateway()->select();
            $select->where('id = ?', $artist->id);
            $row = $this->getGateway()->fetchRow($select);
        } else {
            $row = $this->getGateway()->createRow();
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
    public function fetchAllPaged()
    {

        $select = $this->getGateway()->select();
        $select->order('name', 'ASC');

        $adapter = new Music_Model_Paginator_Artist($select);

        return $adapter;
    }

    public function findByColumnPaged($column, $value)
    {
        $select = $this->getGateway()->select();
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
    public function deleteArtist($artist)
    {
        if ($artist instanceof Music_Model_Artist) {
            if (count($artist->getTracks()) > 0) {
                throw new Zend_Db_Table_Exception(
                    "Artist: $artist->name still has tracks assigned.");
            } elseif (count($artist->getAlbums()) > 0) {
                throw new Zend_Db_Table_Exception(
                    "Artist: $artist->name still has tracks assigned.");
            } else {
                $where = $this->getGateway()->getAdapter()
                    ->quoteInto('id = ?', $artist->id);
            }
        } else {
            $result = $this->findById($artist);
            if (count($result->getTracks()) > 0) {
                throw new Zend_Db_Table_Exception(
                    "Artist: $result->name still has tracks assigned.");
            } elseif (count($result->getAlbums()) > 0) {
                throw new Zend_Db_Table_Exception(
                    "Artist: $result->name still has albums assigned.");
            } else {
                $where = $this->getGateway()->getAdapter()
                    ->quoteInto('id = ?', $artist);
            }
        }
        $this->getGateway()->delete($where);
    }
}
