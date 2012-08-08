<?php

/**
 * Description of Video_Model_Video
 *
 * @author john
 */
class Video_Model_Video extends Jgs_Model_Entity_Abstract
{
    protected $_title;
    protected $_year;
    protected $_director;
    protected $_producers;
    protected $_actors;
    protected $_description;
    protected $_path;
    protected $_length;
    protected $_resolution;
    protected $_poster;
    protected $_imdb;
    protected $_url;
    protected $_genre;
    protected $_genreMapper = NULL;

    public function getTitle() {
        return $this->_title;
    }

    public function setTitle($title) {
        $this->_title = $title;
    }

    public function getYear() {
        return $this->_year;
    }

    public function setYear($year) {
        $this->_year = $year;
    }

    public function getDirector() {
        return $this->_director;
    }

    public function setDirector($director) {
        $this->_director = $director;
    }

    public function getProducers() {
        return $this->_producers;
    }

    public function setProducers($producers) {
        $this->_producers = $producers;
    }

    public function getActors() {
        return $this->_actors;
    }

    public function setActors($actors) {
        $this->_actors = $actors;
    }

    public function getDescription() {
        return $this->_description;
    }

    public function setDescription($description) {
        $this->_description = $description;
    }

    public function getPath() {
        return $this->_path;
    }

    public function getUrl() {
        return $this->_url;
    }

    public function setUrl($url) {
        $this->_url = $url;
    }

    public function setPath($path) {
        $this->_path = $path;
        return $this;
    }

    public function getLength() {
        return $this->_length;
    }

    public function setLength($length) {
        $this->_length = $length;
    }

    public function getResolution() {
        return $this->_resolution;
    }

    public function setResolution($resolution) {
        $this->_resolution = $resolution;
    }

    public function getPoster() {
        return $this->_poster;
    }

    public function setPoster($poster) {
        $this->_poster = $poster;
    }

    public function getImdb() {
        return $this->_imdb;
    }

    public function setImdb($imdb) {
        $this->_imdb = $imdb;
        return $this;
    }

    public function getGenre() {
        if (!$this->_genreMapper) {
            $this->_genreMapper = new Video_Model_Mapper_Genre();
        }
        $array = $this->getReferenceId('genre');
        $genre = $this->_genreMapper->findAll($array);
        return $genre;
    }

    public function setGenre($genre) {
        $util = new Jgs_Utilities();
        $array = explode(',', $genre);
        $genre = $util->arrayTrim($array);

        $this->setReferenceId('genre', $genre);
        return $this;
    }
}
