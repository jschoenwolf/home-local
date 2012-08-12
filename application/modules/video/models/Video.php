<?php

/**
 * Description of Video_Model_Video
 *
 * @author john
 */
class Video_Model_Video extends Jgs_Model_Entity_Abstract
{
    protected $title;
    protected $year;
    protected $director;
    protected $producers;
    protected $actors;
    protected $description;
    protected $path;
    protected $length;
    protected $resolution;
    protected $poster;
    protected $imdb;
    protected $url;
    protected $genre;
    protected $genreMapper = null;

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getYear()
    {
        return $this->year;
    }

    public function setYear($year)
    {
        $this->year = $year;
    }

    public function getDirector()
    {
        return $this->director;
    }

    public function setDirector($director)
    {
        $this->director = $director;
    }

    public function getProducers()
    {
        return $this->producers;
    }

    public function setProducers($producers)
    {
        $this->producers = $producers;
    }

    public function getActors()
    {
        return $this->actors;
    }

    public function setActors($actors)
    {
        $this->actors = $actors;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function setUrl($url)
    {
        $this->url = $url;
    }

    public function setPath($path)
    {
        $this->path = $path;
        return $this;
    }

    public function getLength()
    {
        return $this->length;
    }

    public function setLength($length)
    {
        $this->length = $length;
    }

    public function getResolution()
    {
        return $this->resolution;
    }

    public function setResolution($resolution)
    {
        $this->resolution = $resolution;
    }

    public function getPoster()
    {
        return $this->poster;
    }

    public function setPoster($poster)
    {
        $this->poster = $poster;
    }

    public function getImdb()
    {
        return $this->imdb;
    }

    public function setImdb($imdb)
    {
        $this->imdb = $imdb;
        return $this;
    }

    public function getGenre()
    {
        if (!$this->genreMapper) {
            $this->genreMapper = new Video_Model_Mapper_Genre();
        }
        $array = $this->getReferenceId('genre');
        $genre = $this->genreMapper->findAll($array);
        return $genre;
    }

    public function setGenre($genre)
    {
        $util = new Jgs_Utilities();
        $array = explode(',', $genre);
        $genre = $util->arrayTrim($array);

        $this->setReferenceId('genre', $genre);
        return $this;
    }
}
