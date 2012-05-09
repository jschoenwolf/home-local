<?php

class Application_Model_DbTable_Videos extends Zend_Db_Table_Abstract
{
    protected $_name = 'videos';

    public function saveVideo(array $data) {

        $dataObject = (object) $data;
        if (array_key_exists('id', $data) && isset($data['id'])) {
            $row = $this->find($dataObject->id)->current();
        } else {
            $row = $this->createRow();
        }
        $row->title       = $dataObject->title;
        $row->year        = $dataObject->year;
        $row->director    = $dataObject->director;
        $row->producers   = $dataObject->producers;
        $row->actors      = $dataObject->actors;
        $row->description = $dataObject->description;
        $row->path        = $dataObject->path;
        $row->length      = $dataObject->length;
        $row->resolution  = $dataObject->resolution;
        $row->poster      = $dataObject->poster;
        $row->imdb        = $dataObject->imdb;
        $row->genre1      = $dataObject->genre1;
        $row->genre2      = $dataObject->genre2;
        $row->genre3      = $dataObject->genre3;
        $row->genre4      = $dataObject->genre4;

        $row->save();

        return $row;
    }

    public function fetchVideoRow($imdb) {

        $select = $this->select();
        $select->where('imdb = ?', $imdb);

        $row = $this->fetchRow($select);
        if (!$row) {
            return FALSE;
        } else {
            return $row;
        }
    }

    public function getVideo($id) {

        $select = $this->select();
        $select->where('id = ?', $id);

        $row = $this->fetchRow($select);

        return $row;
    }

    public function fetchAllMoviesPaged() {
        $select = $this->select();
        $select->order('title, ASC');

        $adapter = new Zend_Paginator_Adapter_DbTableSelect($select);
        return $adapter;
    }

    public function fetchPagedMoviesByGenre($genre) {

        $select = $this->select();
        $select->where('genre1 = ?', $genre);
        $select->orWhere('genre2 = ?', $genre);
        $select->orWhere('genre3 = ?', $genre);
        $select->orWhere('genre4 = ?', $genre);
        $select->order('title', 'ASC');

        //create a new instance of the paginator adapter and return it
        $adapter = new Zend_Paginator_Adapter_DbTableSelect($select);

        return $adapter;
    }

    public function fetchPagedMoviesByTitle($title) {

        $select = $this->select();
        $select->where("title LIKE '%$title%'");
        $select->order('title', 'ASC');

        //create a new instance of the paginator adapter and return it
        $adapter = new Zend_Paginator_Adapter_DbTableSelect($select);

        return $adapter;
    }
}

