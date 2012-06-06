<?php

class Application_Model_DbTable_Artist extends Zend_Db_Table_Abstract {

    protected $_name = 'artist';
    protected $_primary = 'id';
    protected $_dependentTables = array('Application_Model_DbTable_Album',
        'Application_Model_DbTable_Track');

}

