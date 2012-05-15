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
    /**
     * Array of identiy values representing previously accomplished Database
     * queries, values are check for current data before doing Database query.
     *
     * @var array
     */
    protected $_identityMap = array();
    /**
     * Makes select object available to mapper as a property.
     *
     * @var Zend_Db_Table_Select
     */
    protected $_select = NULL;

    public function __construct(Zend_Db_Table_Abstract $tableGateway = NULL) {

        if (is_null($tableGateway)) {

            $this->_tableGateway = new Zend_Db_Table($this->_tableName);

        } else {

            $this->_tableGateway = $tableGateway;
        }
        $this->_select = $this->_getGateway()->select();
    }

    public function fetchByColumn($column, $value) {
        $select = $this->_select;
        $select->where("$column = ?", $value);
        $row = $this->_getGateway()->fetchRow($select);

        if (is_null($row)) {
            return NULL;
        } else {
            return $row;
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
     *
     * @param string $id
     * @return string
     */
    protected function _getIdentity($id) {

        if (array_key_exists($id, $this->_identityMap)) {

            return $this->_identityMap[$id];
        }
    }

    /**
     *
     * @param string $id
     * @param string $entity
     */
    protected function _setIdentity($id, $entity) {

        $this->_identityMap[$id] = $entity;
    }

    public function findById($id) {
        $select = $this->_select;
        $select->where('id = ?', $id);
        $row = $this->_getGateway()->fetchRow($select);
        if (is_null($row)) {
            return NULL;
        }
        return $this->createEntity($row);
    }


    abstract protected function createEntity($row);
}
