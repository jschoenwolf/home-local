<?php

class Admin_MusicController extends Zend_Controller_Action
{

    public function init() {

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

    public function updateartistAction() {
        $id = $this->getRequest()->getParam('id');

        $model = new Music_Model_Mapper_Artist();
        $artists = $model->findById(20);
        $this->view->thumbPath = '/images/mp3art/thumbs/';
        $this->view->artists = $artists;
    }
}

