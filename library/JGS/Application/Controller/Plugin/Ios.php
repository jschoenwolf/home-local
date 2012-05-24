<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Ios
 *
 * @author john
 */
class My_Application_Controller_Plugin_Ios extends Zend_Controller_Plugin_Abstract {

    public function preDispatch(Zend_Controller_Request_Abstract $request) {
        parent::preDispatch($request);

        if ($_SESSION['user']['iPhone']) {
            $this->_helper->layout->setLayout('osriphone');
            $this->_helper->viewRenderer->setRender('iphone/index');
        }
    }

}

?>
