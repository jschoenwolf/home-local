<?php

class Karaoke_IndexController extends Zend_Controller_Action
{

    public function preDispatch()
    {
        $this->_helper->layout()->search = $this->_helper->search(
                '/karaoke/index/display', 'Search Karaoke Collection!', 'Karaoke'
        );
        $this->_helper->layout()->login = $this->_helper->login();
    }

    public function init()
    {
        if ($this->_helper->FlashMessenger->hasMessages()) {
            $this->view->messages = $this->_helper->FlashMessenger->getMessages();
        }
    }

    public function indexAction()
    {
        $table = new Application_Model_DbTable_Karaoke();
        Zend_Debug::dump($table->getAdapter()->listTables(), 'Adapter Table List');
//        $model = new Karaoke_Model_Mapper_Karaoke();
//        $adapter = $model->fetchPaged();
//
//        $paginator = new Zend_Paginator($adapter);
//        $paginator->setItemCountPerPage(10);
//
//        $page = $this->getRequest()->getParam('page', 1);
//        $paginator->setCurrentPageNumber($page);
//
//        $this->view->paginator = $paginator;
    }

    public function displayAction()
    {
        $model = new Karaoke_Model_Mapper_Karaoke();
        $query = $this->getRequest()->getParam('query');
        $adapter = $model->fetchPagedByQuery($query);

        $paginator = new Zend_Paginator($adapter);
        $paginator->setItemCountPerPage(16);

        $page = $this->getRequest()->getParam('page', 1);
        $paginator->setCurrentPageNumber($page);

        $this->view->paginator = $paginator;
    }
}

