<?php

class Video_IndexController extends Zend_Controller_Action
{

    public function preDispatch() {

        $searchForm = new Application_Form_MovieSearch();
        $searchForm->setAction('/video/index/display');
        $searchForm->search->setLabel('Search Movie Collection');
        $searchForm->setDecorators(array(
            array('ViewScript', array(
                    'viewScript' => '_searchForm.phtml'
            ))
        ));

        $this->_helper->layout()->search = $searchForm;


        if ($this->getRequest()->getActionName() == 'play') {
            $this->_helper->layout->setLayout('play');
            $this->view->headLink()->appendStylesheet('http://vjs.zencdn.net/c/video-js.css');
            $this->view->headScript()->appendFile(
                    'http://vjs.zencdn.net/c/video.js');
        }
    }

    public function init() {

        if ($this->_helper->FlashMessenger->hasMessages()) {
            $this->view->messages = $this->_helper->FlashMessenger->getMessages();
        }
    }

    public function indexAction() {

        $genre = new Application_Model_DbTable_Genre();
        $genres = $genre->fetchAllGenre();
        $this->view->genre = $genres;
    }

    public function displayAction() {

        $model = new Application_Model_DbTable_Videos();
        $request = $this->getRequest()->getParams();

        switch ($request) {
            case (array_key_exists('id', $request) && isset($request['id'])):
                $adapter = $model->fetchPagedMoviesByGenre($request['id']);
                break;

            case (array_key_exists('query', $request) && isset($request['query'])):
                $adapter = $model->fetchPagedMoviesByTitle($request['query']);
                break;

            default :
                $adapter = $model->fetchAllMoviesPaged();
        }
        $paginator = new Zend_Paginator($adapter);
        $paginator->setItemCountPerPage(16);

        $page = $this->getRequest()->getParam('page', 1);
        $paginator->setCurrentPageNumber($page);

        $this->view->paginator = $paginator;
    }

    public function playAction() {

        $id = $this->getRequest()->getParam('id');
        $model = new Application_Model_DbTable_Videos();
        $video = $model->getVideo($id);

        $this->view->video = $video;
    }
}

