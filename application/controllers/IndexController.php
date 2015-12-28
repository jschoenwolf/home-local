<?php

class IndexController extends Zend_Controller_Action {

    protected $session;
    protected $config;
    protected $message;

    public function preDispatch() {
        
    }

    public function init() {
        $this->message = $this->getHelper('FlashMessenger');
        $this->session = new Zend_Session_Namespace('home');

        if ($this->message->hasMessages()) {
            $this->view->messages = $this->message->getMessages();
        }
    }

    public function indexAction() {
        $this->forward("index", "index", "karaoke");
    }

}
