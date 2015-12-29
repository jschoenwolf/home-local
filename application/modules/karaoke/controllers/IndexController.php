<?php

class Karaoke_IndexController extends Zend_Controller_Action
{

    public function preDispatch()
    {
//        $this->_helper->layout()->search = $this->_helper->search(
//            '/karaoke/index/display', 'Search Karaoke Collection!', 'Karaoke'
//        );
    }

    public function init()
    {
        if ($this->_helper->FlashMessenger->hasMessages()) {
            $this->view->messages = $this->_helper->FlashMessenger->getMessages();
        }
    }

    public function indexAction()
    {
        $this->view->headTitle('Karaoke: Ordered by Id.', Zend_View_Helper_Placeholder_Container_Abstract::SET);
        $model = new Karaoke_Model_Mapper_Karaoke();
        $adapter = $model->fetchPaged();

        $paginator = new Zend_Paginator($adapter);
        $paginator->setItemCountPerPage(20);

        $page = $this->getRequest()->getParam('page', 1);
        $paginator->setCurrentPageNumber($page);
        $paginator->setPageRange(5);

        $this->view->paginator = $paginator;
    }

    public function displayAction()
    {
        $this->view->headTitle('Karaoke: By query.', Zend_View_Helper_Placeholder_Container_Abstract::SET);

        $model = new Karaoke_Model_Mapper_Karaoke();
        $query = $this->getRequest()->getParam('query');
        $adapter = $model->fetchPagedByQuery($query);

        $paginator = new Zend_Paginator($adapter);
        $paginator->setItemCountPerPage(16);

        $page = $this->getRequest()->getParam('page', 1);
        $paginator->setCurrentPageNumber($page);

        $this->view->paginator = $paginator;
    }
    
    public function artistAction()
    {
        $this->view->headTitle('Karaoke: By Artist.', Zend_View_Helper_Placeholder_Container_Abstract::SET);
        
        $model = new Karaoke_Model_Mapper_Artist();
        $adapter = $model->fetchArtist();
        
        $paginator = new Zend_Paginator($adapter);
        $paginator->setItemCountPerPage(20);
        
        $page = $this->getRequest()->getParam('page', 1);
        $paginator->setCurrentPageNumber($page);
        
        $this->view->paginator = $paginator;
    }
}
