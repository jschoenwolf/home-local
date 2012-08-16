<?php

/**
 * Description of Video_Model_Video
 *
 * @author john
 */
class Video_Model_Video extends Jgs_Model_Entity_Abstract
{
    /*
     * Object Properties
     */
    protected $actors;
    protected $description;
    protected $director;
    protected $genre;
    protected $imdb;
    protected $length;
    protected $path;
    protected $poster;
    protected $producers;
    protected $resolution;
    protected $title;
    protected $url;
    protected $year;
    /*
     * Utility Classess
     */
    protected $genreMapper = null;

    /*     * ********************************
     * Getters
     * ********************************* */

    public function getActors()
    {
        return $this->actors;
    }

    /**
     * Selects Genre key from Reference array
     * to find the Genre Object of each of the values present
     * in the Video Object.
     *
     * @return array of Genre Entity Objects
     */
    public function getGenre()
    {
        if (!$this->genreMapper) {
            $this->genreMapper = new Video_Model_Mapper_Genre();
        }
        $array = $this->getReferenceId('genre');
        $genre = $this->genreMapper->findAll($array);
        return $genre;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getDirector()
    {
        return $this->director;
    }

    public function getImdb()
    {
        return $this->imdb;
    }

    public function getLength()
    {
        return $this->length;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function getPoster()
    {
        return $this->poster;
    }

    public function getProducers()
    {
        return $this->producers;
    }

    public function getResolution()
    {
        return $this->resolution;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function getYear()
    {
        return $this->year;
    }

    public function setActors($actors)
    {
        $this->actors = $actors;
    }
    /*     * ********************************
     * Setters
     * ********************************* */

    /**
     * Takes Genre comma separated string and convert into an array
     * to be stored in the reference array for later accessing.
     *
     * @param array $genre
     * @return \Video_Model_Video
     */
    public function setGenre($genre)
    {
        $util = new Jgs_Utilities();
        $array = explode(',', $genre);
        $genre = $util->arrayTrim($array);

        $this->setReferenceId('genre', $genre);
        return $this;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function setDirector($director)
    {
        $this->director = $director;
    }

    public function setImdb($imdb)
    {
        $this->imdb = $imdb;
        return $this;
    }

    public function setLength($length)
    {
        $this->length = $length;
    }

    public function setPath($path)
    {
        $this->path = $path;
        return $this;
    }

    public function setProducers($producers)
    {
        $this->producers = $producers;
    }

    public function setPoster($poster)
    {
        $this->poster = $poster;
    }

    public function setResolution($resolution)
    {
        $this->resolution = $resolution;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function setUrl($url)
    {
        $this->url = $url;
    }

    public function setYear($year)
    {
        $this->year = $year;
    }
}
