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

        $model = new Application_Model_Mapper_Artist();
        $adapter = $model->fetchAllPaged();

        $paginator = new Zend_Paginator($adapter);
        $paginator->setItemCountPerPage(48)->setPageRange(5);

        $page = $this->getRequest()->getParam('page', 1);
        $paginator->setCurrentPageNumber($page);

        $this->view->paginator = $paginator;

    }

    public function displayAction() {

        $request = $this->getRequest()->getParams();
        $model = new Application_Model_Mapper_Track();

        switch ($request) {
            case (array_key_exists('query', $request) && isset($request['query'])):
                $adapter = $model->fetchPagedTracks(NULL, $request['query']);
                break;
            case (array_key_exists('id', $request) && isset($request['id'])):
                $adapter = $model->fetchPagedTracks($request['id']);
                break;
            default:
                $adapter = $model->fetchPagedTracks();
                break;
        }
        $paginator = new Zend_Paginator($adapter);
        $paginator->setItemCountPerPage(15)->setPageRange(5);

        $page = $this->_request->getParam('page', 1);
        $paginator->setCurrentPageNumber($page);

        $this->view->paginator = $paginator;

        $this->view->thumbPath = '/images/mp3art/thumbs/';
    }

    public function albumAction() {

        $id = $this->_request->getParam('id');

        $model = new Application_Model_Mapper_Track();
        $album = $model->fetchAlbum($id);
        $this->view->album = $album;
        Zend_Debug::dump($album, 'Album');
        $this->view->artPath = '/images/mp3art/';
    }
}

