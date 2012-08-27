<?php

/**
 * Description of User
 *
 * @author John Schoenwolf
 */
class Application_Model_Mapper_User extends Jgs_Model_Mapper_Abstract
{
    protected $tableName = 'users';

    public function __construct(Zend_Db_Table_Abstract $tableGateway = null)
    {
        if (is_null($tableGateway)) {
            $tableGateway = new Application_Model_DbTable_User();
        } else {
            $tableGateway = $tableGateway;
        }

        parent::__construct($tableGateway);
    }

    protected function createEntity($row)
    {
        $data = array(
            'id'       => $row->id,
            'name'     => $row->name,
            'password' => $row->password,
            'role'     => $row->role,
        );
        $user = new Application_Model_User($data);

        return $user;
    }

    private function hashPassword($password){
        return Jgs_Password::createPasswordHash($password);
    }

    public function saveUser(Application_Model_User $user)
    {
        if (!is_null($user->id) && !is_null($this->findById($user->id))) {
            $select = $this->getGateway()->select();
            $select->where('id = ?', $user->id);
            $row = $this->getGateway()->fetchRow($select);
        } else {
            $row = $this->getGateway()->createRow();
            $row->password = $this->hashPassword($user->password);
        }
        $row->name = $user->name;
        $row->role = $user->role;

        $row->save();
        return $row;
    }

}
