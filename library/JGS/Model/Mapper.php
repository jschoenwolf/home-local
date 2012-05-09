<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Mapper
 *
 * @author john
 */
class JGS_Model_Mapper
{
    protected $_tableGateway = NULL;
    protected $_identityMap = array();

    public function __construct(Zend_Db_Table_Abstract $tableGateway = NULL) {

        if (is_null($tableGateway)) {

            $this->_tableGateway = new Zend_Db_Table($this->_tableName);

        } else {

            $this->_tableGateway = $tableGateway;
        }
    }

    protected function _getGateway() {

        return $this->_tableGateway;
    }

    protected function _getIdentity($id) {

        if (array_key_exists($id, $this->_identityMap)) {

            return $this->_identityMap[$id];
        }
    }

    protected function _setIdentity($id, $entity) {

        $this->_identityMap[$id] = $entity;
    }
}
