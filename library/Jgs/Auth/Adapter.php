<?php

/**
 * Description of Adapter
 *
 * @author John Schoenwolf
 */
class Jgs_Auth_Adapter implements Zend_Auth_Adapter_Interface
{
    protected $_name;
    protected $_password;

    function __construct($name, $password)
    {
        $this->_name = $name;
        $this->_password = $password;
    }

    public function authenticate()
    {
        if (empty($this->_name) || empty($this->_password)) {
            throw new Zend_Auth_Adapter_Exception();
        }
        if ($this->_name != self::DEFAULT_NAME || $this->_password != self::DEFAULT_PASSWORD) {
            return new Zend_Auth_Result(Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID, array());
        }
        return new Zend_Auth_Result(Zend_Auth_Result::SUCCESS, array(
                'name' => self::DEFAULT_NAME,
                'password' => self::DEFAULT_PASSWORD
            ));
    }
}
