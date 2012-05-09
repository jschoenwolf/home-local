<?php

class Application_Model_DbTable_Mp3Tags extends Zend_Db_Table_Abstract
{

    protected $_name = 'mp3_tags';
    protected $_primary = 'id';


    public function getAllId3Tags() {

        $result = $this->fetchAll();

        return $result;
    }

    public function fetchPaginatorAdapter($filters = array(), $sortField = NULL,
            $groupBy = NULL) {

        $select = $this->select();

        //add any filters which are set
        if (count($filters) > 0) {
            foreach ($filters as $field => $filter) {
                $select->where($field . '=?', $filter);
            }
        }
        //add the sort field is it set
        if (NULL != $sortField) {
            $select->order($sortField);
        }
        if (NULL != $groupBy) {
            $select->group($groupBy);
        }
        //create a new instance of the paginator adapter and return it
        $adapter = new Zend_Paginator_Adapter_DbTableSelect($select);

        return $adapter;
    }

    public function groupBy($groupBy){

        $select = $this->select();
        $select->where(count('*'), 'album');
        $select->group($groupBy);
        $select->order('album');

        $result = $this->fetchAll($select);

        return $result;
    }

}

