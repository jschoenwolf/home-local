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
        $this->_helper->layout->disableLayout();
        //id3 options
//        $options  = array("version"  => 3.0, "encoding" => Zend_Media_Id3_Encoding::ISO88591, "compat"   => true);
        //path to collection
//        $path     = APPLICATION_PATH . '/../public/Media/Music/';//Currently Approx 2000 files
        //inner iterator
//        $dir      = new RecursiveDirectoryIterator($path, RecursiveDirectoryIterator::SKIP_DOTS);
        //iterator
//        $iterator = new RecursiveIteratorIterator($dir, RecursiveIteratorIterator::SELF_FIRST);
        /*
         * Zend_Layout in its current implementation accumulates whole action output inside itself.
         * This fact hampers out intention to gradually output the result.
         * What we do here is we defer execution of our intensive calculation in form of callback into the Postpone plugin.
         * The scenario is:
         * 1. Application started
         * 2. Layout is started
         * 3. Action gets executed (except callback) and its output is collected by layout.
         * 4. Layout output goes to response.
         * 5. Postpone::postDispatch outputs first part of the response (without the tail).
         * 6. Postpone::postDispatch calls the callback. Its output goes stright to browser.
         * 7. Postpone::postDispatch prints the tail.
         */
//        $this->getFrontController()
//            ->registerPlugin(new Jgs_Controller_Plugin_Postpone(function () {
//                        /*
//                         * A calculation immigration
//                         * Put your actual calculations here.
//                         */
                        echo str_repeat(" ", 1500);
                        foreach (range(1, 5) as $x) {
                            echo "<p>$x</p><br />";
                            usleep(500000);
                            ob_flush();
                            flush();
                        }
//                    }), 1000);

    }

    public function registerAction()
    {
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

    public function loginAction()
    {
        $form = new Application_Form_Login();

        if ($this->getRequest()->isPost()) {
            if ($form->isValid($this->getRequest()->getPost())) {
                $data = $form->getValues();
                $authAdapter = new Jgs_Auth_Adapter($data['name'], $data['password']);
            } else {
                $this->view->form = $form;
                $this->view->errors = $form->getMessages();
            }
            //authenticate
            $result = $authAdapter->authenticate();
            if ($result->isValid()) {
                //store the user object
                $auth = Zend_Auth::getInstance();
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
