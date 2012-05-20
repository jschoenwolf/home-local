<?php

class Application_Model_DbTable_Track extends Zend_Db_Table_Abstract
{
    protected $_name = 'track';
    protected $_primary = 'id';
//    protected $_referenceMap = array(
//        'Artist' => array(
//            'columns'       => 'artist_id',
//            'refTableClass' => 'Application_Model_DbTable_Artist',
//            'refColumns'    => 'id'
//        ),
//        'Album' => array(
//            'columns'       => 'album_id',
//            'refTableClass' => 'Application_Model_DbTable_Album',
//            'refColumns'    => 'id'
//            ));

}

