<?php

/**
 * Description of Jgs_Application_Model_Mapper
 * Base mapper model to build data mappers around.
 *
 * @author john
 */
abstract class Jgs_Application_Model_Mapper
{
    /**
     * Instance of Zend_Db_Table_Abstract
     *
     * @var Zend_Db_Table_Abstract $_tableGateway
     */
    protected $_tableGateway = NULL;
    protected $_data;

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
     *
     * @return Zend_Db_Table_Abstract
     */
    protected function _getGateway() {

        return $this->_tableGateway;
    }

    /**
     * findByColumn() returns an array of rows selected
     * by column name and column value.
     * Optional orderBy value.
     *
     * @param string $column
     * @param string $value
     * @param string $order
     * @return array
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
            $entities[] = $entity;
        }
        return $entities;
    }

    /**
     * findById() is proxy for find() method and returns
     * an entity object.
     *
     * @param type $id
     * @return object Jgs_Application_Model_Entity_Abstract
     */
    public function findById($id) {

            $select = $this->_getGateway()->select();
            $select->where('id = ?', $id);

            $row = $this->_getGateway()->fetchRow($select);

            if (is_null($row)) {
                return NULL;
            }
            $entity = $this->createEntity($row);

            return $entity;

    }

    /**
     * findAll() is a proxy for the fetchAll() method and returns
     * an array of entity objects.
     * Optional Order parameter. Pass order as string ie. 'id ASC'
     *
     * @return array
     */
    public function findAll($order = NULL) {

        $select = $this->_getGateway()->select();
        if (!is_null($order)) {
            $select->order($order);
        }
        $rowset = $this->_getGateway()->fetchAll($select);
        $entities = array();
        foreach ($rowset as $row) {
            $entity = $this->createEntity($row);
            $entities[] = $entity;
        }
        return $entities;
    }

    /**
     * Abstract method to be implemented by concrete mappers.
     */
    abstract protected function createEntity($row);
}
