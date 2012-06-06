<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Video
 *
 * @author john
 */
class Video_Model_Video extends Jgs_Application_Model_Entity_Abstract {

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
    protected $_genre1;
    protected $_genre2;
    protected $_genre3;
    protected $_genre4;
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

    public function setPath($path) {
        $this->_path = $path;
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
    }

    public function getGenre1() {
        return $this->_genre1;
    }

    public function setGenre1($genre1) {
        $this->_genre1 = $genre1;
    }

    public function getGenre2() {
        return $this->_genre2;
    }

    public function setGenre2($genre2) {
        $this->_genre2 = $genre2;
    }

    public function getGenre3() {
        return $this->_genre3;
    }

    public function setGenre3($genre3) {
        $this->_genre3 = $genre3;
    }

    public function getGenre4() {
        return $this->_genre4;
    }

    public function setGenre4($genre4) {
        $this->_genre4 = $genre4;
    }

}
