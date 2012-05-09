<?php

class Application_Model_DbTable_Album extends Zend_Db_Table_Abstract {

    protected $_name = 'album';
    protected $_primary = 'id';
    protected $_dependentTables = array('Application_Model_DbTable_Track');
    protected $_referenceMap = array('Track' => array(
            'columns' => 'id',
            'refTableClass' => 'Application_Model_DbTable_Track',
            'refColumns' => 'album_id'
            ));

    public function fetchAlbumRow($fieldName = NULL, $fieldValue = NULL) {

        $select = $this->select();
        $select->where("$fieldName = ?", $fieldValue);

        $result = $this->fetchRow($select);
        if ($result) {
            return $result;
        } else {
            return FALSE;
        }
    }

    public function saveAlbum(array $data) {

        $dataObject = (object) $data;

        if (array_key_exists('id', $data)) {
            $row = $this->find($dataObject->id)->current();
        } else {
            $row = $this->createRow();
        }

        $row->name = $dataObject->name;
        $row->artist_id = $dataObject->artist_id;
        $row->art = $dataObject->art;
        $row->year = $dataObject->year;

        $row->save();

        return $row;
    }

    public function fetchPagedAlbums() {

        $select = $this->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
                ->setIntegrityCheck(FALSE);
        $select->join(array('ar' => 'artist'), 'ar.id = album.artist_id',
                array('artist_name' => 'name'));
        $select->join(array('t' => 'track'), 'album.id = t.album_id',
                array('title', 'filename', 'format', 'genre', 'track',
            'play_time', 'bit_rate'));
        $select->order('ar.name', 'ASC');
        $select->order('album.name', 'ASC');
        $select->order('track', 'ASC');

        $adapter = new Zend_Paginator_Adapter_DbTableSelect($select);

        return $adapter;
    }

    public function fetchAlbum($id) {

        $select = $this->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
                ->setIntegrityCheck(FALSE);
        $select->where('album.id = ?', $id);
        $select->join(array('ar' => 'artist'), 'ar.id = album.artist_id',
                array('artist' => 'name'));
        $select->join(array('t' => 'track'), 'album.id = t.album_id',
                array('title', 'filename', 'format', 'genre', 'track',
            'play_time', 'path'));
        $select->order('track', 'ASC');

        $result = $this->fetchAll($select);

        return $result;
    }

}

