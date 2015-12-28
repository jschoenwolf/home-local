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
        
    }

    public function registerAction() {
        $form = new Application_Form_User();
        $form->setDescription('Hello');
        $form->removeElement('id');

        if ($this->getRequest()->isPost()) {
            if ($form->isValid($this->getRequest()->getPost())) {
                $data = $form->getValues();

                $user = new Application_Model_User($data);
                $mapper = new Application_Model_Mapper_User();

                $save = $mapper->saveUser($user);

                $this->message->addMessage("User $save->name added");
                return $this->_redirect('/index');
            }
            $this->view->form = $form;
        } else {
            $this->view->form = $form;
        }
    }

}
