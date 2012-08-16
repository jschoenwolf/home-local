<?php

/**
 * Description of Video_Model_Mapper_Genre
 *
 * @author John Schoenwolf
 */
class Video_Model_Mapper_Genre extends Jgs_Model_Mapper_Abstract
{
    protected $_tableName = 'genre';

    /**
     *
     * @param Zend_Db_Table_Abstract $tableGateway
     */
    function __construct(Zend_Db_Table_Abstract $tableGateway = null)
    {
        $tableGateway = new Application_Model_DbTable_Genre();
        parent::__construct($tableGateway);
    }

    /**
     *
     * @param object $row
     * @return \Video_Model_Genre
     */
    protected function createEntity($row)
    {
        $data = array(
            'id'   => $row->id,
            'name' => $row->name
        );

        return new Video_Model_Genre($data);
    }

    /**
     *
     * @param Video_Model_Genre $genre
     * @return object
     */
    public function saveGenre(Video_Model_Genre $genre)
    {

        if (!is_null($genre->id)) {
            $select = $this->getGateway()->select();
            $select->where('id = ?', $genre->id);
            $row = $this->getGateway()->fetchRow($select);
        } else {
            $row = $this->getGateway()->createRow();
        }
        $row->name = $genre->name;

        $row->save();
        return $row;
    }
}
