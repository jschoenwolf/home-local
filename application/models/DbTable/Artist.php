<?php

class Application_Model_DbTable_Artist extends Zend_Db_Table_Abstract {

    protected $_name = 'artist';
    protected $_primary = 'id';
    protected $_dependentTables = array('Application_Model_DbTable_Album',
        'Application_Model_DbTable_Track');

    public function fetchArtistRow($column = NULL, $value = NULL) {

        $select = $this->select();
        $select->where("$column = ?", $value);

        $result = $this->fetchRow($select);
        if ($result) {
            return $result;
        } else {
            return FALSE;
        }
    }

    public function saveArtist(array $data) {

        $dataObject = (object) $data;

       if (array_key_exists('id', $data)) {
            $row = $this->find($dataObject->id)->current();
        } else {
            $row = $this->createRow();
        }
            $row->name = $dataObject->name;

        $row->save();

        return $row;
    }

}

