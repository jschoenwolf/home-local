<?php

class NewPersonController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
       try{
           throw new Exception('help');
    }catch (Exception $e){
        $this->view->exception = $e->getMessage().'<br />'.$e->getTraceAsString();
    }

    }


}

