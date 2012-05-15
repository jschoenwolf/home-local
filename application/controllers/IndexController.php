<?php

class IndexController extends Zend_Controller_Action
{
    protected $_session;
    protected $_config;
    protected $_message;

    public function init() {

        $this->_message = $this->getHelper('FlashMessenger');
        $this->_session = new Zend_Session_Namespace('home');

        if ($this->_message->hasMessages()) {
            $this->view->messages = $this->_message->getMessages();
        }
    }

    public function indexAction() {

        $model = new Application_Model_Mapper_Track();
        $track = $model->fetchByColumn('artist_id', 23);
//        Zend_Debug::dump($track, 'Track');
//        Zend_Debug::dump($track->album, 'Album');
//        Zend_Debug::dump($track->album->artist, 'Album Artist');
//        Zend_Debug::dump($track->artist, 'Artist');
    }
}

