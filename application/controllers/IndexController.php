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

        if($this->message->hasMessages()) {
            $this->view->messages = $this->message->getMessages();
        }
    }

    public function indexAction()
    {
        //id3 options
        $options  = array("version"  => 3.0, "encoding" => Zend_Media_Id3_Encoding::ISO88591, "compat"   => true);
        //path to collection
        $path     = APPLICATION_PATH . '/../public/Media/Music/';//Currently Approx 2000 files
        //inner iterator
        $dir      = new RecursiveDirectoryIterator($path, RecursiveDirectoryIterator::SKIP_DOTS);
        //iterator
        $iterator = new RecursiveIteratorIterator($dir, RecursiveIteratorIterator::SELF_FIRST);
        foreach($iterator as $file) {
            if(!$file->isDir() && $file->getExtension() === 'mp3') {
                //real path to mp3 file
                $filePath = $file->getRealPath();
                Zend_Debug::dump($filePath);//current results: accepted path no errors
                $id3      = new Zend_Media_Id3v2($filePath, $options);
                foreach($id3->getFramesByIdentifier("T*") as $frame) {
                    $data[$frame->identifier] = $frame->text;
                }
                Zend_Debug::dump($data);//currently can scan the whole collection without timing out, but APIC data not being processed.
            }
        }
    }

    public function registerAction()
    {
        $form = new Application_Form_User();
        $form->setDescription('Hello');
        $form->removeElement('id');
        if($this->getRequest()->isPost()) {
            if($form->isValid($this->getRequest()->getPost())) {
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

        if($this->getRequest()->isPost()) {
            if($form->isValid($this->getRequest()->getPost())) {
                $data        = $form->getValues();
                $authAdapter = new Jgs_Auth_Adapter($data['name'], $data['password']);
            } else {
                $this->view->form   = $form;
                $this->view->errors = $form->getMessages();
            }
            //authenticate
            $result = $authAdapter->authenticate();
            if($result->isValid()) {
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
