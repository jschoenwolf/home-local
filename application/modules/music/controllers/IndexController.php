<?php

class Music_IndexController extends Zend_Controller_Action
{
    protected $_utilities = null;
    protected $_message;

    public function preDispatch() {

        $this->view->headScript()->appendFile(
                '/javascript/mediaelement/build/mediaelement-and-player.min.js');

        $this->view->inlineScript()->setScript(
                "$('audio').mediaelementplayer();");

        $searchForm = new Application_Form_Search();
        $searchForm->setAction('/music/index/display');
        $searchForm->search->setLabel('Search Music Collection');
        $searchForm->setDecorators(array(
            array('ViewScript', array(
                    'viewScript' => '_searchForm.phtml'
            ))
        ));

        $this->_helper->layout()->search = $searchForm;
    }

    public function init() {

        $this->_message = $this->getHelper('FlashMessenger');
        if ($this->_message->hasMessages()) {
            $this->view->messages = $this->_message->getMessages();
        }
        $this->_utilities = new Jgs_Application_Utilities();
    }

    public function indexAction() {

        $model = new Music_Model_Mapper_Artist();
        $adapter = $model->fetchAllPaged();

        $paginator = new Zend_Paginator($adapter);
        $paginator->setItemCountPerPage(48)->setPageRange(5);

        $page = $this->getRequest()->getParam('page', 1);
        $paginator->setCurrentPageNumber($page);

        $this->view->paginator = $paginator;
    }

    public function displayAction() {

        $request = $this->getRequest()->getParams();

        switch ($request) {
            case (array_key_exists('query', $request) && isset($request['query'])):
                $model = new Music_Model_Mapper_Track();
                $adapter = $model->fetchPagedTracks(NULL, $request['query']);
                $paginator = new Zend_Paginator($adapter);
                $paginator->setItemCountPerPage(20)->setPageRange(5);

                $page = $this->getRequest()->getParam('page', 1);
                $paginator->setCurrentPageNumber($page);

                $this->view->paginator = $paginator;
                $this->view->artPath = '/images/mp3art/';
                break;
            case (array_key_exists('id', $request) && isset($request['id'])):
                $this->_forward('artist', NULL, NULL, array('id' => $request['id']));
                break;
            default:
                $adapter = $model->fetchPagedTracks();
                break;
        }
    }

    public function artistAction() {
        $id = $this->getRequest()->getParam('id');
        $artist = new Music_Model_Mapper_Artist();
        if (count($artist->findById($id)->getAlbums()) > 0) {
            $model = new Music_Model_Mapper_Album();
            $adapter = $model->findByIdPaged('artist_id ', $id);
        } else {
            $track = new Music_Model_Mapper_Track();
            $adapter = $track->findByIdPaged('artist_id', $id);
        }

        $paginator = new Zend_Paginator($adapter);
        $paginator->setItemCountPerPage(1)->setPageRange(5);

        $page = $this->getRequest()->getParam('page', 1);
        $paginator->setCurrentPageNumber($page);

        $this->view->paginator = $paginator;
        $this->view->artPath = '/images/mp3art/';
    }

    public function albumAction() {

        $id = $this->_request->getParam('id');

        $model = new Music_Model_Mapper_Album();
        $adapter = $model->findByIdPaged('id ', $id);

        $paginator = new Zend_Paginator($adapter);
        $paginator->setItemCountPerPage(1)->setPageRange(5);

        $page = $this->getRequest()->getParam('page', 1);
        $paginator->setCurrentPageNumber($page);

        $this->view->paginator = $paginator;
        $this->view->artPath = '/images/mp3art/';
    }
}

