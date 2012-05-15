<?php

class Music_Model_Artist extends Jgs_Application_Model_Entity_Abstract implements Jgs_Application_Interface_Artist
{
    protected $_id;
    protected $_name;

    public function __construct($name) {
        $this->setName($name);
    }

    public function getId() {
        return $this->_id;
    }

    public function getName() {
        return htmlspecialchars_decode($this->_name, ENT_QUOTES);
    }

    public function setId($id) {
        if (!is_null($this->_id)) {
            throw new BadMethodCallException(
                "The ID for this 'Artist' has been set already."
            );
        }
        if (!is_int($id) || $id < 1 || strlen($id) > 4) {
            throw new InvalidArgumentException(
                "The posted value 'Artist ID' is invalid, must be integer between 1 and 9999"
            );
        }
        $this->_id = $id;
        return $this;
    }

    public function setName($name) {
        if (!is_string($name) || strlen($name) < 2 || strlen($name) > 255) {
            throw new InvalidArgumentException(
                "The posted value for 'Artist Name' is invalid"
            );
        }
        $this->_name = htmlspecialchars(trim($name), ENT_QUOTES);
        return $this;
    }
}

