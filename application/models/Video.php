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
    protected $title;
    protected $year;
    protected $genre = array();
    protected $director;
    protected $producers;
    protected $actors;
    protected $description;
    protected $path;
    protected $length;
    protected $resolution;
    protected $poster;
    protected $imdb;
    private $utility;

    public function __construct(array $options = null) {

        if (is_array($options)) {
            $this->setOptions($options);
        }
        $this->utility = new Jgs_Utilities();
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
            if ($row === false) {
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
        if ($row !== false) {
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
        return $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function getYear() {
        return $this->year;
    }

    public function setYear($year) {
        $this->year = $year;
    }

    public function getGenreString() {
        $string = implode(',', $this->genre);
        return $string;
    }

    public function getGenreArray() {
        return $this->genre;
    }

    public function setGenre($genre) {
        $array = explode(',', $genre);
        $result = $this->utility->arrayTrim($array);

        $this->genre = $result;
    }

    public function getDirector() {
        return $this->director;
    }

    public function setDirector($director) {
        $this->director = $director;
    }

    public function getProducers() {
        return $this->producers;
    }

    public function setProducers($producers) {
        $this->producers = $producers;
    }

    public function getActors() {
        return $this->actors;
    }

    public function setActors($actors) {
        $this->actors = $actors;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function getPath() {
        return $this->path;
    }

    public function setPath($path) {
        $this->path = $this->utility->trimPath($path, 2);
    }

    public function getLength() {
        return $this->length;
    }

    public function setLength($length) {
        $this->length = $length;
    }

    public function getResolution() {
        return $this->resolution;
    }

    public function setResolution($resolution) {
        $this->resolution = $resolution;
    }

    public function getPoster() {
        return $this->poster;
    }

    public function setPoster($poster) {
        $this->poster = $poster;
    }

    public function getImdb() {
        return $this->imdb;
    }

    public function setImdb($imdb) {
        $this->imdb = $imdb;
    }
}
