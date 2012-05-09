<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Artist
 *
 * @author john
 */
class Application_Model_Mapper_Artist extends JGS_Model_Mapper
{
    protected $_tableName = 'artist';
    protected $_entityClass = 'Application_Model_Artist';

    public function find($id) {

        if ($this->_getIdentity($id)) {
            return $this->_getIdentity($id);
        }
        $result = $this->_getGateway()->find($id)->current();

        $artist = new $this->_entityClass(array(
                    'id'   => $result->id,
                    'name' => $result->name
                ));
        $this->_setIdentity($id, $artist);

        return $artist;
    }
}
