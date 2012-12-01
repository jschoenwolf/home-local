<?php

/**
 * Description of Jgs_Controller_Action_Helper_Login
 *
 * @author John Schoenwolf
 */
class Jgs_Controller_Action_Helper_Login extends Zend_Controller_Action_Helper_Abstract
{
    /**
     *
     * @return \Application_Form_Login
     */
    public function direct()
    {
        $form = new Application_Form_Login();
        $form->setAction('/index/login');

        return $form;
    }

}
