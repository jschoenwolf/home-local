<?php

class Application_Model_DbTable_Genre extends Zend_Db_Table_Abstract
{
    protected $_name = 'genre';
    protected $_primary = 'id';

    public function saveGenre(array $data)
    {

        $dataObject = (object) $data;
        if (array_key_exists('id', $data) && isset($data['id'])) {
            $row = $this->find($dataObject->id)->current();
        } else {
            $row = $this->createRow();
        }
        $row->name = $dataObject->name;
        $row->save();

        return $row;
    }

    public function fetchGenreRow($fieldName = null, $fieldValue = null)
    {

        $select = $this->select();
        $select->where("$fieldName = ?", $fieldValue);

        $result = $this->fetchRow($select);
        if (!$result) {
            return false;
        } else {
            return $result;
        }
    }

    public function fetchAllGenre()
    {
        $select = $this->select();
        $select->order('name ASC');

        $result = $this->fetchAll($select);

        return $result;
    }
}

