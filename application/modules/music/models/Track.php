<?php

class Music_Model_Track extends Jgs_Application_Model_Entity_Abstract
implements Jgs_Application_Interface_Track
{

    protected $_id;
    protected $_album;
    protected $_artist;
    protected $_filename;
    protected $_format;
    protected $_genre;
    protected $_hash;
    protected $_path;
    protected $_play_time;
    protected $_title;
    protected $_track;




    function __construct($album, $artist, $filename, $format, $genre, $hash, $path, $play_time, $title, $track) {
        $this->_album     = $album;
        $this->_artist    = $artist;
        $this->_filename  = $filename;
        $this->_format    = $format;
        $this->_genre     = $genre;
        $this->_hash      = $hash;
        $this->_path      = $path;
        $this->_play_time = $play_time;
        $this->_title     = $title;
        $this->_track     = $track;
    }

    public function getAlbum() {
        return $this->_album;
    }

    public function getArtist() {
        return $this->_artist;
    }

    public function getFilename() {
        return $this->_filename;
    }

    public function getFormat() {
        return $this->_format;
    }

    public function getGenre() {
        return $this->_genre;
    }

    public function getHash() {
        return $this->_hash;
    }

    public function getId() {
        return $this->_id;
    }

    public function getPath() {
        return $this->_path;
    }

    public function getPlay_time() {
        return $this->_play_time;
    }

    public function getTitle() {
        return $this->_title;
    }

    public function getTrack() {
        return $this->_track;
    }

    public function setAlbum($album) {
        if (!$album instanceof Music_Model_Album) {
            throw new InvalidArgumentException(
                "The posted value for 'Album' is invalid, must be
                    instance of Music_Model_Album"
            );
        }
        $this->_album = $album;
        return $this;
    }

    public function setArtist($artist) {
        if (!$album instanceof Music_Model_Artist) {
            throw new InvalidArgumentException(
                "The posted value for 'Artist' is invalid, must be
                    instance of Music_Model_Artist"
            );
        }
        $this->_artist = $artist;
        return $this;
    }

    public function setFilename($filename) {
        $this->_filename = $filename;
        return $this;
    }

    public function setFormat($format) {
        $this->_format = $format;
        return $this;
    }

    public function setGenre($genre) {
        $this->_genre = $genre;
        return $this;
    }

    public function setHash($hash) {
        $this->_hash = $hash;
        return $this;
    }

    public function setId($id) {
        if (!is_null($id)) {
            throw new BadMethodCallException(
                    "The 'ID' for this track has already been set."
            );
        }
        if (!is_int($id) || $id < 1 || strlen($id) > 4) {
            throw new InvalidArgumentException(
                    "The posted value for 'Track ID' is invalid"
            );
        }
        $this->_id = $id;
        return $this;
    }

    public function setPath($path) {
        $this->_path = $path;
        return $this;
    }

    public function setPlay_time($play_time) {
        $this->_play_time = $play_time;
        return $this;
    }

    public function setTitle($title) {
        $this->_title = $title;
        return $this;
    }

    public function setTrack($track) {
        $this->_track = $track;
        return $this;
    }

}

