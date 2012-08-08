<?php

class Admin_MoviexmlController extends Zend_Controller_Action
{
    protected $_xmlUtilities = null;
    protected $_session;
    protected $_message;

    public function preDispatch() {

    }

    public function init() {

        $this->_xmlUtilities = new Jgs_XmlUtilities();
        $this->_session = new Zend_Session_Namespace('xml');
        $this->_message = $this->getHelper('FlashMessenger');
        if ($this->_message->hasMessages()) {
            $this->view->messages = $this->_message->getMessages();
        }
    }

    public function indexAction() {
        $form = new Application_Form_Music();
        $form->setAction('/admin/moviexml/index');
        $this->view->file = $this->_session->file;
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($this->getRequest()->getPost())) {
                $form->getValues();
                Zend_Debug::dump($form->getValues(), 'Get Values');
                $this->_session->file = $form->file->getFileName();
                $this->_redirect($this->getRequest()->getRequestUri());
            }
        }
        $this->view->form = $form;
    }

    public function genreAction() {
        $util = new Jgs_Utilities();
        $model = new Application_Model_Video();
        try {

            if (!isset($this->_session->file)) {
                return $this->_forward('index');
            } else {
                $movies = $this->_xmlUtilities->xmlMoviesToArray($this->_session->file);
            }
            foreach ($movies as $movie) {
                $array = explode(',', $movie['genre']);
                $array = $util->arrayTrim($array);
                Zend_Debug::dump($array, 'Array');
                foreach ($array as $genre) {
                    $gateWay = new Application_Model_DbTable_Genre ();
                    $model = new Video_Model_Mapper_Genre($gateWay);
                    Zend_Debug::dump($model->findByColumn('name', $genre), 'Genre Object');
                    Zend_Debug::dump($genre, 'Raw');
                }
            }
        } catch (Zend_Controller_Action_Exception $e) {
            $this->_helper->flashMessenger->addMessage($e->getMessage());
            $this->_helper->flashMessenger->addMessage($e->getTrace());
            $this->getHelper('Redirector')->gotoSimple('index');
        }
    }

    public function movieAction() {
        $model = new Application_Model_Video();
        try {
            if (!isset($this->_session->file)) {
                return $this->_forward('index');
            } else {
                $movies = $this->_xmlUtilities->xmlMoviesToArray($this->_session->file);
            }
            foreach ($movies as $movie) {
                if (strpos($movie['genre'], 'TV Shows') === FALSE) {
                    $model->setOptions($movie);
                    $model->saveMovie();
                }
            }
            $this->_helper->flashMessenger->addMessage('Movies saved to database.');
            $this->getHelper('Redirector')->gotoSimple('index');
        } catch (Zend_Controller_Action_Exception $e) {
            $this->_helper->flashMessenger->addMessage($e->getMessage());
            $this->_helper->flashMessenger->addMessage($e->getTrace());
            $this->getHelper('Redirector')->gotoSimple('index');
        }
    }

    public function tvAction() {
        $model = new Application_Model_Video();
        try {
            if (!isset($this->_session->file)) {
                return $this->_forward('index');
            } else {
                $movies = $this->_xmlUtilities->xmlMoviesToArray($this->_session->file);
            }
            foreach ($movies as $movie) {
                if (strpos($movie['genre'], 'TV Shows') !== FALSE) {
                    $model->setOptions($movie);
                    $model->saveMovie();
                }
            }
            $this->_helper->flashMessenger->addMessage('TV Shows saved to database.');
            $this->getHelper('Redirector')->gotoSimple('index');
        } catch (Zend_Controller_Action_Exception $e) {
            $this->_helper->flashMessenger->addMessage($e->getMessage());
            $this->_helper->flashMessenger->addMessage($e->getTrace());
            $this->getHelper('Redirector')->gotoSimple('index');
        }
    }

    public function clearfileAction() {

        Zend_Session::namespaceGet('xml');
        Zend_Session::namespaceUnset('xml');

        $this->getHelper('Redirector')->gotoSimple('index');
    }
}

