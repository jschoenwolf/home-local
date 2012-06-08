<?php

/**
 * Description of Genre
 *
 * @author John Schoenwolf
 */
class Video_Model_Mapper_Genre extends Jgs_Application_Model_Mapper
{

    protected $_tableName = 'genre';


    function __construct(Zend_Db_Table_Abstract $tableGateway) {
        $tableGateway = new Application_Model_DbTable_Genre();
        parent::__construct($tableGateway);
    }

    protected function createEntity($row) {
        $data = array(
            'id'   => $row->id,
            'name' => $row->name
        );

        return new Video_Model_Genre($data);
    }
}
