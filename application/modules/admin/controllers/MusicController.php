<?php

class Admin_MusicController extends Zend_Controller_Action
{
    protected $message;
    protected $thumbPath = '/images/mp3art/thumbs/';
    private $session;

    public function preDispatch()
    {

        $searchForm = new Application_Form_Search();
        $searchForm->setAction('/admin/music/update');
        $searchForm->query->setAttribs(array('placeholder' => 'Search for Artist',
            'size'        => 27,
        ));
        $searchForm->search->setLabel('Find an Artist\'s work.');
        $searchForm->setDecorators(array(
            array('ViewScript', array(
                    'viewScript' => '_searchForm.phtml'
            ))
        ));

        $this->_helper->layout()->search = $searchForm;
    }

    public function init()
    {
        $this->session = new Zend_Session_Namespace('songs');
        $this->message = $this->getHelper('FlashMessenger');
        if ($this->message->hasMessages()) {
            $this->view->messages = $this->message->getMessages();
        }
    }

    public function indexAction()
    {

    }

    public function readAction()
    {
        /* @var $form Application_Form_Music */
        $form = new Application_Form_Music();
        $form->setAction('/admin/music/read');

        $taginfo = new Music_Model_TagInfo();
        try {
            if ($this->getRequest()->isPost()) {
                if ($form->isValid($this->getRequest()->getPost())) {
                    $file = $form->file->getFileName();
                    $form->getValues();
                    if ($form->file->isUploaded()) {
                        $utilities = new Jgs_Utilities();
                        $tracks = $utilities->csvToArray($file);
                        $track = array_shift($tracks);
                    }

                    foreach ($tracks as $track) {
                        if (is_array($track)) {
                            set_time_limit(30);
                            $taginfo->setOptions($track);
                            $tag = new Music_Model_Tag($taginfo);
                            $tag->track();
                        }
                    }
                    $count = count($tracks);
                    $this->_helper->flashMessenger->addMessage("$count, new songs added to database.");
                    $this->_redirect('/admin/music/index');
                }
            }
            $this->view->form = $form;
        } catch (Zend_Exception $e) {
            $this->_helper->flashMessenger->addMessage($e->getMessage() . ' ' . $e->getTraceAsString());
            $this->_redirect('/admin/music/index');
        }
    }

    public function updateAction()
    {

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

        $this->view->thumbPath = $this->thumbPath;
    }

    public function updatetrackAction()
    {
        $session = new Zend_Session_Namespace('page');
        $id = $this->getRequest()->getParam('id');

        $model = new Music_Model_Mapper_Track();
        $track = $model->findById($id);

        $form = new Admin_Form_Track();
        $form->setAction('/admin/music/updatetrack/');

        if ($this->getRequest()->isPost()) {
            if ($form->isValid($this->getRequest()->getPost())) {
                $data = $form->getValues();

                $newTrack = new Music_Model_Track($data);

                $update = $model->saveTrack($newTrack);

                $this->message->addMessage("Update of track '$update->title' complete!");
                $this->getHelper('Redirector')->gotoSimple('update', null, null, array('page' => $session->page));
            }
        } else {
            $form->populate($track->toArray());
            $this->view->form = $form;
        }
    }

    public function updatealbumAction()
    {
        $session = new Zend_Session_Namespace('page');
        $id = $this->getRequest()->getParam('id');

        $model = new Music_Model_Mapper_Album();
        $album = $model->findById($id);

        $form = new Admin_Form_Album();
        $form->setAction('/admin/music/updatealbum/');

        if ($this->getRequest()->isPost()) {
            if ($form->isValid($this->getRequest()->getPost())) {
                $data = $form->getValues();

                $newAlbum = new Music_Model_Album($data);

                $update = $model->saveAlbum($newAlbum);

                $this->message->addMessage("Update of Album '$update->name' complete!");
                $this->getHelper('Redirector')->gotoSimple('update', null, null, array('page' => $session->page));
            }
        } else {
            $form->populate($album->toArray());
            $this->view->form = $form;
        }
    }

    public function updateartistAction()
    {
        $session = new Zend_Session_Namespace('page');
        $id = $this->getRequest()->getParam('id');

        $model = new Music_Model_Mapper_Artist();
        $artist = $model->findById($id);

        $form = new Admin_Form_Artist();
        $form->setAction('/admin/music/updateartist/');

        if ($this->getRequest()->isPost()) {
            if ($form->isValid($this->getRequest()->getPost())) {
                $data = $form->getValues();

                $newArtist = new Music_Model_Artist($data);

                $update = $model->saveArtist($newArtist);

                $this->message->addMessage("Update of artist '$update->name' complete!");
                $this->getHelper('Redirector')->gotoSimple('update', null, null, array('page' => $session->page));
            }
        } else {
            $form->populate($artist->toArray());
            $this->view->form = $form;
        }
    }

    public function deleteAction()
    {
        $session = new Zend_Session_Namespace('page');
        $request = $this->getRequest()->getParams();
        try {
            switch ($request) {
                case isset($request['trackId']):
                    $id = $request['trackId'];
                    $model = new Music_Model_Mapper_Track();
                    $model->deleteTrack($id);
                    $this->message->addMessage("Track Deleted!");

                    break;
                case isset($request['albumId']):
                    $id = $request['albumId'];
                    $model = new Music_Model_Mapper_Album();
                    $model->deletealbum($id);
                    $this->message->addMessage("Album Deleted!");

                    break;
                case isset($request['artistId']):
                    $id = $request['artistId'];
                    $model = new Music_Model_Mapper_Artist();
                    $model->deleteArtist($id);
                    $this->message->addMessage("Artist Deleted!");

                    break;

                default:
                    break;
            }
            $this->getHelper('Redirector')->gotoSimple('update', null, null, array('page' => $session->page));
        } catch (Exception $e) {
            $this->message->addMessage($e->getMessage());
            $this->getHelper('Redirector')->gotoSimple('update', null, null, array('page' => $session->page));
        }
    }
}
