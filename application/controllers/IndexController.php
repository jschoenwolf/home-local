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

      
    }
}

