<?php

class IndexController extends Zend_Controller_Action
{
    protected $_session;
    protected $_config;

    public function init() {
        if ($this->_helper->FlashMessenger->hasMessages()) {
            $this->view->messages = $this->_helper->FlashMessenger->getMessages();
        }
        $this->_session = new Zend_Session_Namespace('home');
        $this->_config = Zend_Registry::get('config');
    }

    public function indexAction() {

        $mapper = new Application_Model_Mapper_Track();
        $track = $mapper->find(386);
//
//        $track = $mapper->find(403);
        Zend_Debug::dump($track, 'Track');
        Zend_Debug::dump($track->artist, 'Artist');
        Zend_Debug::dump($track->album, 'Album');

    }
}

