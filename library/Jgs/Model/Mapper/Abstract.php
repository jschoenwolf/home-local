<?php

/**
 * Description of Jgs_Application_Model_Mapper
 * Base mapper model to build data mappers around.
 *
 * @author john
 */
abstract class Jgs_Model_Mapper_Abstract
{
    /**
     * Instance of Zend_Db_Table_Abstract
     *
     * @var Zend_Db_Table_Abstract $_tableGateway
     */
    protected $_tableGateway = NULL;
    protected $_map = array();

    /**
     * Will accept a DbTable model passed or will instantiate
     * a Zend_Db_Table_Abstract object from table name.
     *
     * @param Zend_Db_Table_Abstract $tableGateway
     */
    public function __construct(Zend_Db_Table_Abstract $tableGateway = NULL) {

        if (is_null($tableGateway)) {

            $this->_tableGateway = new Zend_Db_Table($this->_tableName);
        } else {

            $this->_tableGateway = $tableGateway;
        }
    }

    /**
     * Get default database table adapter
     *
     * @return Zend_Db_Table_Abstract
     */
    protected function _getGateway() {

        return $this->_tableGateway;
    }

    /**
     * Set value and name of entity in identity map.
     *
     * @param string $id
     * @param object $entity
     */
    protected function _setMap($id, $entity) {
        $this->_map[$id] = $entity;
    }

    /**
     * Get value of entity id from identity map.
     *
     * @param string $id
     * @return string
     */
    protected function _getMap($id) {
        if (array_key_exists($id, $this->_map)) {
            return $this->_map[$id];
        }
    }

    /**
     * findByColumn() returns an array of rows selected
     * by column name and column value.
     * Optional orderBy value.
     *
     * @param string $column
     * @param string $value
     * @param string $order
     * @return array of entity objects
     */
    public function findByColumn($column, $value, $order = NULL) {

        $select = $this->_getGateway()->select();
        $select->where("$column = ?", $value);

        if (!is_null($order)) {
            $select->order($order);
        }

        $result = $this->_getGateway()->fetchAll($select);

        $entities = array();
        foreach ($result as $row) {
            $entity = $this->createEntity($row);
            $this->_setMap($row->id, $entity);
            $entities[] = $entity;
        }

        return $entities;
    }

    /**
     * findById() is proxy for find() method and returns
     * an entity object.
     *
     * @param type $id
     * @return object Jgs_Model_Entity_Abstract
     */
    public function findById($id) {

        if ($this->_getMap($id)) {
            return $this->_getMap($id);
        }

        $select = $this->_getGateway()->select();
        $select->where('id = ?', $id);

        $row = $this->_getGateway()->fetchRow($select);

        $entity = $this->createEntity($row);

        $this->_setMap($row->id, $entity);

        return $entity;
    }

   /**
    * findAll() is a proxy for the fetchAll() method and returns
    * an array of entity objects.
    *
    * @param array $where an array of id's
    * @param string $order in the format of 'column ASC'
    * @return array of entity objects
    */
    public function findAll(array $where = NULL, $order = NULL) {

        $select = $this->_getGateway()->select();

        if (!is_null($where)) {
            $select->where('id IN (?)', $where);
        }
        if (!is_null($order)) {
            $select->order($order);
        }

        $rowset = $this->_getGateway()->fetchAll($select);

        $entities = array();
        foreach ($rowset as $row) {
            $entity = $this->createEntity($row);
            $this->_setMap($row->id, $entity);
            $entities[] = $entity;
        }

        return $entities;
    }

    /**
     * Abstract method to be implemented by concrete mappers.
     */
    abstract protected function createEntity($row);
}
