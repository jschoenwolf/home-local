<?php

/**
 * Description of Jgs_Auth_Adapter
 *
 * @author John Schoenwolf
 */
class Jgs_Auth_Adapter extends Zend_Auth_Adapter_DbTable
{

    /**
     *  Substitute new hash algorithym for sql functions
     *
     * @return /Zend_Auth_Adapter_DbTable
     */
    public function authenticate()
    {
        $hash = Jgs_Password::createPasswordHash($this->_credential);
        $this->_credential = $hash;

        return parent::authenticate();
    }
}
