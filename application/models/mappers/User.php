<?php

/**
 * Description of User
 *
 * @author John Schoenwolf
 */
class Application_Model_Mapper_User extends Jgs_Model_Mapper_Abstract
{

    protected $_tableName = 'users';

    public function __construct(Zend_Db_Table_Abstract $tableGateway = NULL) {
        $tableGateway = new Application_Model_DbTable_User();
        parent::__construct($tableGateway);
    }

    protected function createEntity($row) {

        $data = array(
            'id' => $row->id,
            'name' => $row->name,
            'password' => $row->password,
            'role' => $row->role,
        );
        $user = new Application_Model_User($data);

        return $user;
    }

    public function saveUser(Application_Model_User $user) {

        if (!empty($user->id) && !is_null($this->findById($user->id))) {
            $select = $this->_getGateway()->select();
            $select->where('id = ?', $user->id);
            $row = $this->_getGateway()->fetchRow($select);
        } else {
            $row = $this->_getGateway()->createRow();
        }
        $row->name = $user->name;
        $row->password = $user->password;
        $row->role = $user->role;

        $row->save();
        return $row;
    }
}
