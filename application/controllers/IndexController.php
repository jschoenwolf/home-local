<?php

class IndexController extends Zend_Controller_Action
{
    protected $session;
    protected $config;
    protected $message;

    public function preDispatch()
    {
        $this->_helper->layout()->login = $this->_helper->login();
    }

    public function init()
    {
        $this->message = $this->getHelper('FlashMessenger');
        $this->session = new Zend_Session_Namespace('home');

        if ($this->message->hasMessages()) {
            $this->view->messages = $this->message->getMessages();
        }
    }

    public function indexAction()
    {
//        $file = MEDIA_MUSIC_PATH . '\\Audioslave\\Audioslave\\01 Be Yourself.mp3';
//        $path = 'images/mp3art/';
//        $info = new Music_Model_Mapper_TagInfo($file);
//        $tag = new Music_Model_Tag($info->getInfo());
//        $model = new Music_Model_Mapper_Album();
//        $album = $model->findById(4);
//        $image = $album->setCoverArt();

     
    }

    public function registerAction()
    {
        $form = new Application_Form_User();
        $form->setDescription('Hello');
        $form->removeElement('id');

        if ($this->getRequest()->isPost()) {
            if ($form->isValid($this->getRequest()->getPost())) {
                $data = $form->getValues();

                $user   = new Application_Model_User($data);
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

    public function loginAction()
    {
        $form = new Application_Form_Login();

        if ($this->getRequest()->isPost()) {
            if ($form->isValid($this->getRequest()->getPost())) {
                $data = $form->getValues();
                $authAdapter = new Jgs_Auth_Adapter($data['name'], $data['password']);
            } else {
                $this->view->form   = $form;
                $this->view->errors = $form->getMessages();
            }

            //authenticate
            $result = $authAdapter->authenticate();
            if ($result->isValid()) {
                //store the user object
                $auth    = Zend_Auth::getInstance();
                $storage = $auth->getStorage();
                $storage->write($authAdapter->getUser());
                $this->message->addMessage('Welcome');
                return $this->_redirect('/');
            } else {
                $this->view->loginMessage =
                    "Sorry, your username or password was incorrect";
            }
        } else {
            $this->view->form = $form;
        }
    }

    public function logoutAction()
    {
        $authAdapter = Zend_Auth::getInstance();
        $authAdapter->clearIdentity();
    }
}
