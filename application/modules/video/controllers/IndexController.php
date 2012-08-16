<?php

class Video_IndexController extends Zend_Controller_Action
{

    public function preDispatch()
    {
        $this->_helper->layout()->search = $this->_helper->search(
            '/video/index/display', 'Search Video Collection!', 'Movie Title');

        if ($this->getRequest()->getActionName() == 'play') {
            $this->_helper->layout->setLayout('play');

            $this->view->headLink()->appendStylesheet('/javascript/video-js/video-js.css');
            $this->view->headScript()->setFile(
                '/javascript/video-js/video.js');
        }
    }

    public function init()
    {
        if ($this->_helper->FlashMessenger->hasMessages()) {
            $this->view->messages = $this->_helper->FlashMessenger->getMessages();
        }
    }

    public function indexAction()
    {
        $genre = new Video_Model_Mapper_Genre();
        $genres = $genre->findAll();
        $this->view->genre = $genres;
    }

    public function displayAction()
    {
        $model = new Video_Model_Mapper_Video();
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

    public function movieAction()
    {
        $id = $this->getRequest()->getParam('id');
        $model = new Video_Model_Mapper_Video();
        $video = $model->findById($id);
        $this->view->video = $video;
    }

    public function playAction()
    {
        $id = $this->getRequest()->getParam('id');
        $model = new Video_Model_Mapper_Video();
        $video = $model->findById($id);

        $this->view->video = $video;
    }
}

