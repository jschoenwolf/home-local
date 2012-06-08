<?php

class Music_Model_Album extends Jgs_Application_Model_Entity_Abstract implements Jgs_Application_Interface_Album
{
    protected $_id;
    protected $_name;
    protected $_art;
    protected $_year;
    protected $_artist;
    protected $_artistMapper = NULL;


    public function getId() {
        return $this->_id;
    }

    public function setId($id) {
        $id = (int)$id;
        if (!is_null($this->_id)) {
            throw new BadMethodCallException(
                "The ID for this post has been set already."
            );
        }
        if (!is_int($id) || $id < 1 || strlen($id) > 4) {
            throw new InvalidArgumentException(
                "The posted 'Album ID' $id is invalid."
            );
        }
        $this->_id = $id;
        return $this;
    }

    public function getName() {
        return htmlspecialchars_decode($this->_name, ENT_QUOTES);
    }

    public function setName($name) {
        if (!is_string($name) || strlen($name) < 2 || strlen($name) > 255) {
            throw new InvalidArgumentException(
                    "The posted 'Album Name' is invalid"
            );
        }
        $this->_name = htmlspecialchars(trim($name), ENT_QUOTES);
        return $this;
    }

    public function getArt() {
        return htmlspecialchars_decode($this->_art, ENT_QUOTES);
    }

    public function setArt($art) {
        if (!is_string($art) || strlen($art) < 2 || strlen($art) > 255) {
            throw new InvalidArgumentException(
                    "The posted 'Album Image Name' is invalid"
            );
        }
        $this->_art = htmlspecialchars(trim($art), ENT_QUOTES);
        return $this;
    }

    public function getYear() {
        return $this->_year;
    }

    public function setYear($year) {
        if (strlen($year) > 4) {
            throw new InvalidArgumentException(
                "The posted value for 'Album Year' is invalid."
            );
        }
        $this->_year = $year;
        return $this;
    }

    public function getArtist() {
        if (!is_null($this->_artist) && $this->_artist instanceof Music_Model_Artist) {
            return $this->_artist;
        } else {
            if (!$this->_artistMapper) {
                $this->_artistMapper = new Music_Model_Mapper_Artist();
            }
            return $this->_artistMapper->findById($this->getReferenceId('artist'));
        }
    }

    public function setArtist($artist) {
        $this->setReferenceId('artist', $artist);
        return $this;
    }

     public function getTracks() {
        $mapper = new Music_Model_Mapper_Track();
        $tracks = $mapper->findByColumn('album_id', $this->_id, 'track ASC');

        return $tracks;
    }
    
}

