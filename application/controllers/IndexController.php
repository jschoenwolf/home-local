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

    }

    public function registerAction()
    {
        $form = new Application_Form_User();

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

    public function loginAction()
    {
        $form = new Application_Form_Login();

        if ($this->getRequest()->isPost()) {
            if ($form->isValid($this->getRequest()->getPost())) {
                $form->getValues();
                Zend_Debug::dump($form->getValues(), 'Form Values');
            }
            $this->view->message = $form->getMessages();
        }
        $this->view->form = $form;
//        //setup the auth adapter
//        //get the default db adapter
//        $db = Zend_Db_Table::getDefaultAdapter();
//        //create the auth adapter
//        $authAdapter = new Zend_Auth_Adapter_DbTable($db, 'users',
//                        'name', 'password');
//        $authAdapter->setIdentity($data['name']);
//        $authAdapter->setCredential(Jgs_Password::comparePassword($data['password'],
//                $authAdapter->getResultRowObject('password')));
//        //authenticate
//        $result = $authAdapter->authenticate();
//        if ($result->isValid()) {
//            //store the username, first and last names of the user
//            $auth = Zend_Auth::getInstance();
//            $storage = $auth->getStorage();
//            $storage->write($authAdapter->getResultRowObject(array(
//                        'username', 'first_name', 'last_name', 'role'
//                    )));
//            return $this->_forward('index');
//        } else {
//            $this->view->loginMessage =
//                    "Sorry, your username or password was incorrect";
//        }
    }

    public function logoutAction()
    {
        $authAdapter = Zend_Auth::getInstance();
        $authAdapter->clearIdentity();
    }
}

