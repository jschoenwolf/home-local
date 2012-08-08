<?php

/**
 * Description of User
 *
 * @author John Schoenwolf
 */
class Application_Model_User extends Jgs_Model_Entity_Abstract
{
    protected $_id;
    protected $_name;
    protected $_password;
    protected $_role;

    public function getId() {
        return $this->_id;
    }

    public function setId($id = NULL) {
        $this->_id = $id;
    }

    public function getName() {
        return $this->_name;
    }

    public function setName($name) {
        $this->_name = $name;
    }

    public function getPassword() {
        return $this->_password;
    }

    public function setPassword($password) {
        $this->_password = Jgs_Password::createPasswordHash($password);
    }

    public function getRole() {
        return $this->_role;
    }

    public function setRole($role = 'guest') {
        $this->_role = $role;
    }
}
