<?php

class Music_Model_Album extends Jgs_Application_Model_Entity_Abstract implements Jgs_Application_Interface_Album
{
    protected $_id;
    protected $_name;
    protected $_art;
    protected $_year;
    protected $_artist;
    protected $_tracks = array();

    function __construct($name, $art, $year, Music_Model_Artist $artist,
     array $tracks) {

        $this->setName($name);
        $this->setArt($art);
        $this->setYear($year);
        $this->setArtist($artist);
        $this->setTracks($tracks);
    }

    public function getId() {
        return $this->_id;
    }

    public function setId($id) {
        if (!is_null($this->_id)) {
            throw new BadMethodCallException(
                "The ID for this post has been set already."
            );
        }
        if (!is_int($id || $id < 1 || strlen($id) > 4)) {
            throw new InvalidArgumentException(
                "The posted 'Album ID' is invalid."
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
        if (!is_int($year) || $year < 1900 || strlen($year) > 4) {
            throw new InvalidArgumentException(
                "The posted value for 'Album Year' is invalid."
            );
        }
        $this->_year = $year;
        return $this;
    }

    public function getArtist() {
        return $this->_artist;
    }

    public function setArtist($artist) {
        if (!$artist instanceof Jgs_Application_Interface_Artist) {
            throw new InvalidArgumentException(
                "Object 'Artist' does not implement interface or is not
                 instance of 'Music_Model_Artist"
            );
        }
        $this->_artist = $artist;
        return $this;
    }

    public function getTracks() {
        return $this->_tracks;
    }

    public function setTracks($tracks) {
        foreach ($tracks as $track) {
            if (!$track instanceof Music_Model_Track) {
                throw new InvalidArgumentException(
                    "One or more 'Tracks' are invalid."
                );
            }
            $this->_tracks = $tracks;
            return $this;
        }
    }
}

