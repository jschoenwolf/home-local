<?php

/**
 * Description of Jgs_Application_Model_Entity
 *
 * @author John Schoenwolf
 */
class Jgs_Application_Model_Entity
{
    /**
     * An array of reference id's for lazy loading related objects.
     *
     * @var array $_references
     */
    protected $_references = array();

    /**
     *
     * @param array $data
     */
    public function __construct(array $data = null) {

        if (!is_null($data)) {

            foreach ($data as $name => $value) {
                $this->{$name} = $value;
            }
        }
    }

    /**
     *
     * @return array $_data
     */
    public function toArray() {

        return $this->_data;
    }

    /**
     *
     * @param string $name
     * @param string $value
     * @throws Zend_Db_Table_Exception
     */
    public function __set($name, $value) {

            if (!array_key_exists($name, $this->_data)) {
                throw new Zend_Db_Table_Exception('This doese not work');
            }
            $this->_data[$name] = $value;
    }

    /**
     *
     * @param string $name
     * @return string
     */
    public function __get($name) {

        if (array_key_exists($name, $this->_data)) {
            return $this->_data[$name];
        }
    }

    /**
     *
     * @param string $name
     * @return bool
     */
    public function __isset($name) {
        return isset($this->_data[$name]);
    }

    /**
     *
     * @param string $name
     */
    public function __unset($name) {
        if (isset($this->_data[$name])) {
            unset($this->_data[$name]);
        }
    }

    /**
     *
     * @param string $name
     * @param string $id
     */
    public function setReferenceId($name, $id) {
        $this->_references[$name] = $id;
    }

    /**
     *
     * @param string $name
     * @return string
     */
    public function getReferenceId($name) {
        if (isset($this->_references[$name])) {
            return $this->_references[$name];
        }
    }
}
