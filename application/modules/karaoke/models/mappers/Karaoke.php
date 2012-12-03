<?php

/**
 * Description of Karaoke
 *
 * @author John Schoenwolf
 */
class Karaoke_Model_Mapper_Karaoke extends Jgs_Model_Mapper_Abstract
{
    protected $tableName = 'karaoke';
    protected $entityClass = 'Karaoke_Model_Karaoke';

    public function __construct(Zend_Db_Table_Abstract $tableGateway = null)
    {
        if (is_null($tableGateway)) {
            $tableGateway = new Application_Model_DbTable_Karaoke();
        } else {
            $tableGateway = $tableGateway;
        }
        parent::__construct($tableGateway);
    }

    public function createEntity($row)
    {
        $data = array(
            'id' => $row->id,
            'title' => $row->title,
            'artist' => $row->artist,
            'manu' => $row->manu,
            'disc' => $row->disc,
            'track' => $row->track_number
        );

        return new Karaoke_Model_Karaoke($data);
    }

    public function fetchPaged()
    {
        $select = $this->getGateway()->select();
        $select->order('id ASC');

        $adapter = new Karaoke_Model_Paginator_Karaoke($select);

        return $adapter;
    }

    public function fetchPagedByQuery($query)
    {
        $select = $this->getGateway()->select();
        $select->where(new Zend_Db_Expr("title LIKE '%$query%'"));
        $select->orWhere(new Zend_Db_Expr("artist LIKE '%$query%'"));
        $select->order('artist ASC');
        $select->order('title ASC');

        $adapter = new Karaoke_Model_Paginator_Karaoke($select);

        return $adapter;
    }
}
