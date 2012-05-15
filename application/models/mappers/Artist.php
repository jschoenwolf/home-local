<?php

/**
 * Description of Application_Model_Mapper_Artist
 *
 * @author John Schoenwolf
 */
class Application_Model_Mapper_Artist extends Jgs_Application_Model_Mapper
{
    /**
     * Name of database table as a string
     *
     * @var string $_tablename
     */
    protected $_tableName = 'artist';
    /**
     * Name of entity model calss as a string.
     *
     * @var string $_entityClass
     */
    protected $_entityClass = 'Application_Model_Artist';

    /**
     * Find a single row in the database table.
     *
     * @param string $id
     * @return Application_Model_Artist
     */
    public function find($id) {

        if ($this->_getIdentity($id)) {
            return $this->_getIdentity($id);
        }
        $select = $this->_select;
        $select->where('id = ?', $id);
        $row = $this->_getGateway()->fetchRow($select);
        if (is_null($row)) {
            return NULL;
        } else {
            $artist = new $this->_entityClass(array(
                        'id'   => $row->id,
                        'name' => $row->name
                    ));
            $this->_setIdentity($id, $artist);

            return $artist;
        }
    }

    /**
     *
     * @return \Zend_Paginator_Adapter_DbTableSelect
     */
    public function fetchAllPaged() {

        $select = $this->_select->order('name', 'ASC');

        $adapter = new Zend_Paginator_Adapter_DbTableSelect($select);

        return $adapter;
    }

    /**
     * Insert or update a single row in database table.
     *
     * @param Application_Model_Album $$artist
     */
    public function save(Application_Model_Album $artist) {

        if (!$$artist->id) {
            $data = array(
                'name'      => $$artist->name
            );
            $$artist->id = $this->_getGateway()->insert($data);
            $this->_setIdentity($$artist->id, $$artist);
        } else {
            $data = array(
                'id'        => $$artist->id,
                'name'      => $$artist->name
            );
            $where = $this->_getGateway()->getAdapter()
                          ->quoteInto('id = ?', $$artist->id);
            $this->_getGateway()->update($data, $where);
        }
    }

    /**
     * Delete a single row in database table.
     *
     * @param Application_Model_Album $artist
     */
     public function delete($artist) {

        if ($artist instanceof Application_Model_Album) {
            $where = $this->_getGateway()->getAdapter()
                          ->quoteInto('id = ?', $artist->id);
        } else {
            $where = $this->_getGateway()->getAdapter()
                          ->quoteInto('id = ?', $artist);
        }
        $this->_getGateway()->delete($where);
    }
    protected function createEntity($row) {

    }

}
