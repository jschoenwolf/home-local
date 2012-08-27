<?php

/**
 * Description of Db_Adapter
 *
 * @author John Schoenwolf
 */
class Jgs_Auth_Adapter implements Zend_Auth_Adapter_Interface
{
    /**
     * The username
     *
     * @var string
     */
    protected $identity = null;
    /**
     * The password
     *
     * @var string
     */
    protected $credential = null;
    /**
     * Users database object
     *
     * @var Jgs_Model_Mapper_Abstract
     */
    protected $usersMapper = null;

    public function __construct($username, $password, Jgs_Model_Mapper_Abstract $userMapper = null)
    {
        if (!is_null($userMapper)) {
            $this->setMapper($userMapper);
        } else {
            $this->usersMapper = new Application_Model_Mapper_User();
        }
        $this->setIdentity($username);
        $this->setCredential($password);
    }

    public function authenticate()
    {
        // Fetch user information according to username
        $user = $this->getUserObject();

        if (is_null($user)) {
            return new Zend_Auth_Result(
                    Zend_Auth_Result::FAILURE_IDENTITY_NOT_FOUND,
                    $this->getIdentity(),
                    array('Invalid username')
            );
        }

        // check whether or not the hash matches
        $check = Jgs_Password::comparePassword($this->getCredential(), $user->password);
        if (!$check) {
            return new Zend_Auth_Result(
                    Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID,
                    $this->getIdentity(),
                    array('Incorrect password')
            );
        }

        // Success!
        return new Zend_Auth_Result(
                Zend_Auth_Result::SUCCESS,
                $this->getIdentity(),
                array()
        );
    }

    public function setIdentity($userName)
    {
        $this->identity = $userName;
        return $this;
    }

    public function setCredential($password)
    {
        $this->credential = $password;
        return $this;
    }

    public function setMapper($mapper)
    {
        $this->usersMapper = $mapper;
        return $this;
    }

    private function getUserObject()
    {
        return $this->getMapper()->findOneByColumn('name', $this->getIdentity());
    }

    public function getUser()
    {
        $object = $this->getUserObject();
        $array = array(
            'id' => $object->id,
            'name' => $object->name,
            'role' => $object->role
        );
        return (object) $array;
    }

    public function getIdentity()
    {
        return $this->identity;
    }

    public function getCredential()
    {
        return $this->credential;
    }

    public function getMapper()
    {
        return $this->usersMapper;
    }
}

