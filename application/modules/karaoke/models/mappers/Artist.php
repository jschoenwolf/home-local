<?php

/**
 * Description of Artist
 *
 * @author John
 */
class Karaoke_Model_Mapper_Artist extends Jgs_Model_Mapper_Abstract {

    protected $tableName = 'karaoke';
    protected $entityClass = 'Karaoke_Model_Artist';

    public function __construct(Zend_Db_Table_Abstract $tableGateway = null) {
        if (is_null($tableGateway)) {
            $tableGateway = new Application_Model_DbTable_Karaoke();
        } else {
            $tableGateway = $tableGateway;
        }
        parent::__construct($tableGateway);
    }

    public function createEntity($row) {
        $data = array(
            'artist' => $row->artist,
        );

        return new Karaoke_Model_Artist($data);
    }

    public function fetchArtist() {
        $select = $this->getGateway()->select()->distinct();
        $select->from($this->getGateway(), 'artist');

        $adapter = new Karaoke_Model_Paginator_Artist($select);

        return $adapter;
    }

}
