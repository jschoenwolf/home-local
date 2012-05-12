<?php

class Admin_MoviexmlController extends Zend_Controller_Action
{
    protected $_xmlUtilities = null;
    protected $_session;

    public function preDispatch() {

    }

    public function init() {
        if ($this->_helper->FlashMessenger->hasMessages()) {
            $this->view->messages = $this->_helper->FlashMessenger->getMessages();
        }
        $this->_xmlUtilities = new Jgs_Application_XmlUtilities();
        $this->_session = new Zend_Session_Namespace('xml');
    }

    public function indexAction() {
        $form = new Application_Form_Music();
        $form->setAction('/admin/moviexml/index');
        $this->view->file = $this->_session->file;
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($this->getRequest()->getPost())) {
                $form->getValues();
                Zend_Debug::dump($form->getValues(), 'Get Values');
//                $this->_session->file = $form->file->getFileName();
//                $this->_redirect($this->getRequest()->getRequestUri());
            }
        }
        $this->view->form = $form;
    }

    public function genreAction() {
        $model = new Application_Model_Video();
        try {

            if (!isset($this->_session->file)) {
                return $this->_forward('index');
            } else {
                $movies = $this->_xmlUtilities->xmlMoviesToArray($this->_session->file);
            }
            foreach ($movies as $movie) {
                $model->setOptions($movie);
                $model->storeGenre();
            }
            $this->_helper->flashMessenger->addMessage('Genres saved to database.');
            $this->getHelper('Redirector')->gotoSimple('index');
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

