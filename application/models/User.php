<?php

/**
 * Description of Application_Model_User
 *
 * @author John Schoenwolf
 */
class Application_Model_User extends Jgs_Model_Entity_Abstract
{
    protected $name;
    protected $password;
    protected $role;

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function setRole($role = 'guest')
    {
        $this->role = $role;
        return $this;
    }
}
