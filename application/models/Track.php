<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Track
 *
 * @author john
 */
class Application_Model_Track extends JGS_Model_Entity
{
    protected $_data = array(
        'id'        => NULL,
        'title'     => '',
        'filename'  => '',
        'path'      => '',
        'format'    => '',
        'genre'     => '',
        'track'     => '',
        'hash'      => '',
        'play_time' => '',
        'artist'    => NULL,
        'album'     => NULL
    );
    protected $_references = array();
    //album
    protected $_albumMapperClass = 'Application_Model_Mapper_Album';
    protected $_albumMapper = NULL;
    //artist
    protected $_artistMapperClass = 'Application_Model_Mapper_Artist';
    protected $_artistMapper = NULL;

    public function __set($name, $value) {
        if ($name == 'album' && !$value instanceof Application_Model_Album) {
            throw new Zend_Db_Table_Exception(
                    "'Album' can only be set using an instance of 'Application_Model_Album'."
            );
        }
        elseif ($name == 'artist' && !$value instanceof Application_Model_Artist) {
            throw new Zend_Db_Table_Exception(
                    "'Artist' can only be set using an instance of 'Application_Model_Artist'."
            );
        }

        parent::__set($name, $value);
    }

    public function __get($name) {
        if ($name == 'album' && $this->getReferenceId('album') &&
                !$this->_data['artist'] instanceof Application_Model_Album) {
            if (!$this->_albumMapper) {
                $this->_albumMapper = new $this->_albumMapperClass();
            }
            $this->_data['album'] = $this->_albumMapper->find($this->getReferenceId('album'));
        }
        elseif ($name == 'artist' && $this->getReferenceId('artist') &&
                !$this->_data['artist'] instanceof Application_Model_Artist) {
            if (!$this->_artistMapper) {
                $this->_artistMapper = new $this->_artistMapperClass();
            }
            $this->_data['artist'] = $this->_artistMapper->find($this->getReferenceId('artist'));
        }
        return parent::__get($name);
    }

    public function setAlbumMapper(Application_Model_Mapper_Album $mapper) {

        $this->_albumMapper = $mapper;
    }

    public function setArtistMapper(Application_Model_Mapper_Artist $mapper) {

        $this->_artistMapper = $mapper;
    }
}
