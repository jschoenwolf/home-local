<?php

class Music_Model_Track extends Jgs_Model_Entity_Abstract implements Jgs_Interface_Track
{
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
    protected $_albumMapper = NULL;
    protected $_artistMapper = NULL;

    public function getAlbum() {
        if (!is_null($this->_album) && $this->_album instanceof Music_Model_Album) {
            return $this->_album;
        } else {
            if (!$this->_albumMapper) {
                $this->_albumMapper = new Music_Model_Mapper_Album();
            }
            return $this->_albumMapper->findById($this->getReferenceId('album'));
        }
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

    public function getPath() {
        return $this->_path;
    }

    public function getPlay_time() {
        return $this->_play_time;
    }

    public function getTitle() {
        return ucwords($this->_title);
    }

    public function getTrack() {
        return $this->_track;
    }

    public function setAlbum($album) {
        $this->setReferenceId('album', $album);
        return $this;
    }

    public function setArtist($artist) {
        $this->setReferenceId('artist', $artist);
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

