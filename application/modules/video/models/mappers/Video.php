<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Video
 *
 * @author john
 */
class Video_Model_Mapper_Video extends Jgs_Application_Model_Mapper {

    protected $_tablename = 'videos';
    protected $_entityClass = 'Video_Model_Video';
    protected $_genreMapper;

    /**
     * accepts instance of Zend_Db_Table_Abstract or a string for database
     * table name.
     *
     * @param Zend_Db_Table_Abstract $tableGateway
     */
    public function __construct(Zend_Db_Table_Abstract $tableGateway = NULL) {
        $tableGateway = new Application_Model_DbTable_Videos();
        parent::__construct($tableGateway);
    }

    protected function createEntity($row) {
        
    }

}

?>
