<?php

class Admin_MusicController extends Zend_Controller_Action
{
    protected $_message;

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

        $model = new Music_Model_Mapper_Artist();
        if (isset($query)) {
            $adapter = $model->findByColumnPaged('name', $query);
        } else {
            $adapter = $model->fetchAllPaged();
        }

        $paginator = new Zend_Paginator($adapter);
        $paginator->setItemCountPerPage(1)->setPageRange(5);

        $page = $this->getRequest()->getParam('page', 1);
        $paginator->setCurrentPageNumber($page);

        $this->view->paginator = $paginator;

        $this->view->thumbPath = '/images/mp3art/thumbs/';
    }

    public function updatetrackAction() {

        $id = $this->_request->getParam('id');
        $model = new Music_Model_Mapper_Track();
        $track = $model->findById($id);
        $form = $this->_form($track);
        $form->setAction('/admin/music/updatetrack');
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($this->getRequest()->getPost())) {
                $data = $form->getValues();
                //$data = $this->_fixData($data);
                $model = new Music_Model_Mapper_Track();
                $update = $model->saveTrack($data);

                $this->_message->addMessage("Update of track '$update->title' complete!");
                $this->getHelper('Redirector')->gotoSimple('update');
            }
        } else {
            $form->populate($track);
            $this->view->form = $form;
        }
    }

    private function _form(array $data) {
        $form = new Zend_Form();
        $form->setMethod('POST');

        foreach ($data as $key => $value) {
            $form->addElement('text', $key, array(
                'label' => $key . ':',
                'attribs' => array('size' => 40),
                'filters' => array('StringTrim', 'StripTags')
            ));
        }
        $form->addElement('submit', 'submit', array(
            'label' => 'Submit'
        ));
        return $form;
    }

    private function _fixData(array $data) {
        if (array_key_exists('artist', $data)) {
            $data['artist_id'] = $data['artist'];
            unset($data['artist']);
        }
        if (array_key_exists('album', $data)) {
            $data['album_id'] = $data['album'];
            unset($data['album']);
        }
        return $data;
    }
}

