<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Album
 *
 * @author john
 */
class Application_Model_Album extends JGS_Model_Entity
{
    protected $_data = array(
        'id'     => NULL,
        'name'   => '',
        'art'    => '',
        'year'   => '',
        'artist' => NULL
    );
    protected $_references = array();

    protected $_artistMapperClass = 'Application_Model_Mapper_Artist';
    protected $_artistMapper = NULL;

    public function __set($name, $value) {

        if ($name == 'artist' && !$value instanceof Application_Model_Artist) {
            throw new Zend_Db_Table_Exception(
                    "'Artist' can only be set using an instance of 'Application_Model_Artist'."
            );
        }
        parent::__set($name, $value);
    }

    public function __get($name) {

        if ($name == 'artist' && $this->getReferenceId('artist') &&
                !$this->_data['artist'] instanceof Application_Model_Artist) {
            if (!$this->_artistMapper) {
                $this->_artistMapper = new $this->_artistMapperClass();
            }
            $this->_data['artist'] = $this->_artistMapper->find($this->getReferenceId('artist'));
        }
        return parent::__get($name);
    }

     public function setArtistMapper(Application_Model_Mapper_Artist $mapper) {

        $this->_artistMapper = $mapper;
    }
}
