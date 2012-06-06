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
}

