<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of video
 *
 * @author john
 */
class Application_Model_Video
{
    protected $_title;
    protected $_year;
    protected $_genre = array();
    protected $_director;
    protected $_producers;
    protected $_actors;
    protected $_description;
    protected $_path;
    protected $_length;
    protected $_resolution;
    protected $_poster;
    protected $_imdb;
    private $_utility;

    public function __construct(array $options = NULL) {

        if (is_array($options)) {
            $this->setOptions($options);
        }
        $this->_utility = new Jgs_Utilities();
    }

    public function setOptions(array $options) {

        $methods = get_class_methods($this);

        foreach ($options as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (in_array($method, $methods)) {
                $this->$method($value);
            }
        }
        return $this;
    }

    public function __set($name, $value) {
        $method = 'set' . ucfirst($name);
        if (!method_exists($this, $method)) {
            throw new Zend_Exception('Invalid Tag Property');
        }
        $this->$method($value);
    }

    public function __get($name) {
        $method = 'get' . ucfirst($name);
        if (!method_exists($this, $method)) {
            throw new Zend_Exception('Invalid Tag Property');
        }
        return $this->$method();
    }

    public function storeGenre() {
        $genre = $this->getGenreArray();
        $model = new Application_Model_DbTable_Genre();
        foreach ($genre as $value) {
            $row = $model->fetchGenreRow('name', $value);
            if ($row === FALSE) {
                //create new row
                $model->saveGenre(array('name' => $value));
            } else {
                //update row
                $model->saveGenre(array(
                    'id' => $row->id,
                    'name' => $value
                ));
            }
        }
    }

    public function saveMovie() {
        $model = new Application_Model_DbTable_Videos();
        $gModel = new Application_Model_DbTable_Genre();
        $genre = array();

        $array = $this->getGenreArray();


        $data = array(
            'title'       => $this->getTitle(),
            'year'        => $this->getYear(),
            'director'    => $this->getDirector(),
            'producers'   => $this->getProducers(),
            'actors'      => $this->getActors(),
            'description' => $this->getDescription(),
            'path'        => $this->getPath(),
            'length'      => $this->getLength(),
            'resolution'  => $this->getResolution(),
            'poster'      => $this->getPoster(),
            'imdb'        => $this->getImdb()
        );
        $data1 = array_merge($data, $genre);
        $row = $model->fetchVideoRow($this->getImdb());
        if ($row !== FALSE) {
            //update row
            $id = array('id' => $row->id);
            $data2 = array_merge($data1, $id);
            $model->saveVideo($data2);
        } else {
            //create new row
            $model->saveVideo($data1);
        }
    }

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

    public function getGenreString() {
        $string = implode(',', $this->_genre);
        return $string;
    }

    public function getGenreArray() {
        return $this->_genre;
    }

    public function setGenre($genre) {
        $array = explode(',', $genre);
        $result = $this->_utility->arrayTrim($array);

        $this->_genre = $result;
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
        $this->_path = $this->_utility->trimPath($path, 2);
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
}
