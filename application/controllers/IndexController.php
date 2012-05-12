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

        echo 'Title = ' .$track->title .
             '<br/>Album Name = ' . $track->album->name .
             '<br />Artist Name = ' . $track->artist->name .
             '<br />Album Artist Name = ' . $track->album->artist->name;


    }
}

