<?php

class Music_Model_Artist extends Jgs_Application_Model_Entity_Abstract implements Jgs_Application_Interface_Artist
{
    protected $_id;
    protected $_name;

    public function __construct($id = NULL, $name) {

        $this->setId($id);
        $this->setName($name);
    }

    public function getId() {
        return $this->_id;
    }

    public function getName() {
        return htmlspecialchars_decode($this->_name, ENT_QUOTES);
    }

    public function setId($id) {
        $id = (int)$id;

        if (!is_int($id) || $id < 1 || strlen($id) > 4) {
            throw new InvalidArgumentException(
                "The posted value 'Artist ID' is invalid, must be integer between 1 and 9999"
            );
        }
        $this->_data['id'] = $id;
        $this->_id = $id;
        return $this;
    }

    public function setName($name) {
        if (!is_string($name) || strlen($name) < 2 || strlen($name) > 255) {
            throw new InvalidArgumentException(
                "The posted value for 'Artist Name' is invalid"
            );
        }
        $this->_data['name'] = $name;
        $this->_name = htmlspecialchars(trim($name), ENT_QUOTES);
        return $this;
    }

    public function getAlbums() {
        $mapper = new Music_Model_Mapper_Album();
        $albums = $mapper->findByColumn('artist_id', $this->_id);

        return $albums;
    }

}

