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
class Video_Model_Mapper_Video extends Jgs_Model_Mapper_Abstract
{
    protected $_tablename   = 'videos';
    protected $_entityClass = 'Video_Model_Video';
    protected $_genreMapper;

    /**
     * accepts instance of Zend_Db_Table_Abstract or a string for database
     * table name.
     *
     * @param Zend_Db_Table_Abstract $tableGateway
     */
    public function __construct(Zend_Db_Table_Abstract $tableGateway = null)
    {
        $tableGateway = new Application_Model_DbTable_Videos();
        parent::__construct($tableGateway);
    }

    /**
     * Create the entity Video_Model_Video
     *
     * @param object $row
     * @return \Video_Model_Video
     */
    public function createEntity($row)
    {
        $data = array(
            'id'          => $row->id,
            'title'       => $row->title,
            'year'        => $row->year,
            'director'    => $row->director,
            'producers'   => $row->producers,
            'actors'      => $row->actors,
            'description' => $row->description,
            'path'        => $row->path,
            'length'      => $row->length,
            'resolution'  => $row->resolution,
            'poster'      => $row->poster,
            'imdb'        => $row->imdb,
            'genre'       => $row->genre,
            'url'         => $row->url
        );
        return new Video_Model_Video($data);
    }

    /**
     * Save or update row in database table videos
     *
     * @param Video_Model_Video $video
     * @return object
     */
    public function saveVideo(Video_Model_Video $video)
    {
        if (!is_null($video->id)) {
            $select = $this->getGateway()->select();
            $select->where('id = ?', $video->id);
            $row = $this->getGateway()->fetchRow($select);
        } else {
            $row = $this->getGateway()->createRow();
        }
        $row->title       = $video->title;
        $row->year        = $video->year;
        $row->director    = $video->director;
        $row->producers   = $video->producers;
        $row->actors      = $video->actors;
        $row->description = $video->description;
        $row->path        = $video->path;
        $row->length      = $video->length;
        $row->resolution  = $video->resolution;
        $row->poster      = $video->poster;
        $row->url         = $video->url;
        $row->imdb        = $video->imdb;
        $row->save();
        return $row;
    }

    /**
     * Create a Zend_Paginator adapter, selected by Genre that returns an
     * array of Video Entity Objects ordered by Title.
     *
     * @param type $genre
     * @return \Video_Model_Paginator_Video
     */
    public function fetchPagedMoviesByGenre($genre)
    {
        $select = $this->getGateway()->select();
        $select->where(new Zend_Db_Expr("FIND_IN_SET('$genre', genre)"));
        $select->order('title', 'ASC');

        //create a new instance of the paginator adapter and return it
        $adapter = new Video_Model_Paginator_Video($select);

        return $adapter;
    }

    /**
     * Create an Zend_Paginator adapter selected by Title query,
     * Oredered by Title. Returns an array of Video Entity Objects.
     *
     * @param type $title
     * @return \Video_Model_Paginator_Video
     */
    public function fetchPagedMoviesByTitle($title)
    {

        $select = $this->getGateway()->select();
        $select->where(new Zend_Db_Expr("title LIKE '%$title%'"));
        $select->order('title', 'ASC');

        //create a new instance of the paginator adapter and return it
        $adapter = new Video_Model_Paginator_Video($select);

        return $adapter;
    }

    /**
     * Create a Zend_Paginator adapter that returns an array of all
     * Video Entity Objects ORDERED by Title.
     *
     * @return \Video_Model_Paginator_Video
     */
    public function fetchAllMoviesPaged()
    {
        $select = $this->getGateway()->select();
        $select->order('title, ASC');

        $adapter = new Video_Model_Paginator_Video($select);
        return $adapter;
    }
}

?>
