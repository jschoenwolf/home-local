<?php

class Admin_MusicController extends Zend_Controller_Action {

    protected $_message;
    protected $_thumbPath = '/images/mp3art/thumbs/';

    public function preDispatch() {

        $searchForm = new Application_Form_Search();
        $searchForm->setAction('/admin/music/update');
        $searchForm->query->setAttribs(array('placeholder' => 'Search for Artist',
            'size' => 27,
        ));
        $searchForm->search->setLabel('Find an Artist\'s work.');
        $searchForm->setDecorators(array(
            array('ViewScript', array(
                    'viewScript' => '_searchForm.phtml'
            ))
        ));

        $this->_helper->layout()->search = $searchForm;
    }

    public function init() {

        $this->_message = $this->getHelper('FlashMessenger');
        if ($this->_message->hasMessages()) {
            $this->view->messages = $this->_message->getMessages();
        }
    }

    public function indexAction() {
        
    }

    public function readAction() {
        /* @var $form Application_Form_Music */
        $form = new Application_Form_Music();
        $form->setAction('/admin/music/read');

        $tags = new Application_Model_Tag();
        try {
            if ($this->getRequest()->isPost()) {
                if ($form->isValid($this->getRequest()->getPost())) {
                    $file = $form->file->getFileName();
                    $form->getValues();
                    if ($form->file->isUploaded()) {
                        $tracks = $this->_utilities->csvToArray($file);
                    }
                    foreach ($tracks as $track) {
                        if (is_array($track)) {
                            $tags->setOptions($track);
                            $tags->saveTags();
                        }
                    }
                    $this->_helper->flashMessenger->addMessage('Operatation Complete.');
                    $this->_redirect($this->getRequest()->getRequestUri());
                }
            }
            $this->view->form = $form;
        } catch (Zend_Exception $e) {
            $this->_helper->flashMessenger->addMessage($e->getMessage());
            $this->_redirect($this->getRequest()->getRequestUri());
        }
    }

    public function updateAction() {

        $query = $this->getRequest()->getParam('query');
        $page = $this->getRequest()->getParam('page', 1);

        $model = new Music_Model_Mapper_Artist();

        if (isset($query)) {
            $adapter = $model->findByColumnPaged('name', $query);
        } else {
            $adapter = $model->fetchAllPaged();
        }

        $paginator = new Zend_Paginator($adapter);
        $paginator->setItemCountPerPage(1)->setPageRange(5);

        $paginator->setCurrentPageNumber($page);

        $this->view->paginator = $paginator;

        $this->view->thumbPath = $this->_thumbPath;
    }

    public function updatetrackAction() {
        $session = new Zend_Session_Namespace('page');
        $id = $this->getRequest()->getParam('id');

        $model = new Music_Model_Mapper_Track();
        $track = $model->findById($id)->toArray();

        $form = $this->_form($track);
        $form->setAction('/admin/music/updatetrack/');

        if ($this->getRequest()->isPost()) {
            if ($form->isValid($this->getRequest()->getPost())) {
                $data = $form->getValues();
                $newTrack = new Music_Model_Track($data);

                $update = $model->saveTrack($newTrack);

                $this->_message->addMessage("Update of track '$update->title' complete!");
                $this->getHelper('Redirector')->gotoSimple('update', NULL, NULL,
                        array('page' => $session->page));
            }
        } else {
            $form->populate($track);
            $this->view->form = $form;
        }
    }

    public function updatealbumAction() {
        $session = new Zend_Session_Namespace('page');
        $id = $this->getRequest()->getParam('id');

        $model = new Music_Model_Mapper_Album();
        $album = $model->findById($id)->toArray();

        $form = $this->_form($album);
        $form->setAction('/admin/music/updatealbum/');

        if ($this->getRequest()->isPost()) {
            if ($form->isValid($this->getRequest()->getPost())) {
                $data = $form->getValues();
                $newAlbum = new Music_Model_Album($data);

                $update = $model->saveAlbum($newAlbum);

                $this->_message->addMessage("Update of Album '$update->name' complete!");
                $this->getHelper('Redirector')->gotoSimple('update', NULL, NULL,
                        array('page' => $session->page));
            }
        } else {
            $form->populate($album);
            $this->view->form = $form;
        }
    }

    public function updateartistAction() {
        $session = new Zend_Session_Namespace('page');
        $id = $this->getRequest()->getParam('id');

        $model = new Music_Model_Mapper_Artist();
        $artist = $model->findById($id)->toArray();

        $form = $this->_form($artist);
        $form->setAction('/admin/music/updateartist/');

        if ($this->getRequest()->isPost()) {
            if ($form->isValid($this->getRequest()->getPost())) {
                $data = $form->getValues();
                $newArtist = new Music_Model_Artist($data);

                $update = $model->saveArtist($newArtist);

                $this->_message->addMessage("Update of track '$update->name' complete!");
                $this->getHelper('Redirector')->gotoSimple('update', NULL, NULL,
                        array('page' => $session->page));
            }
        } else {
            $form->populate($artist);
            $this->view->form = $form;
        }
    }

    public function deleteAction() {
        $session = new Zend_Session_Namespace('page');
        $id = $this->getRequest()->getParams('trackId');
        $model = new Music_Model_Mapper_Track();
        $model->deleteTrack($id);
        $this->_message->addMessage("Track Deleted!");
        $this->getHelper('Redirector')->gotoSimple('update', NULL, NULL,
                array('page' => $session->page));
    }

    private function _form(array $data) {
        $form = new Zend_Form();
        $form->setMethod('POST');

        foreach ($data as $key => $value) {
            if ($key == 'id' || $key == 'hash') {
                $form->addElement('hidden', $key);
            } else {
                $form->addElement('text', $key,
                        array(
                    'label' => $key . ':',
                    'attribs' => array('size' => 40),
                    'filters' => array('StringTrim', 'StripTags')
                ));
            }
        }
        $form->addElement('submit', 'submit',
                array(
            'label' => 'Submit Changes'
        ));
        return $form;
    }

}

