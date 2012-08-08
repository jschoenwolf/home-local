<?php

/**
 * Description of Jgs_Controller_Action_Helper_Search
 *
 * @author John Schoenwolf
 */
class Jgs_Controller_Action_Helper_Search extends Zend_Controller_Action_Helper_Abstract
{

    public function direct($action, $label = NULL, $placeHolder = NULL) {
        $form = new Application_Form_Search();
        $form->setAction($action);
        $form->search->setLabel($label);
        $form->query->setAttribs(array('placeholder' => $placeHolder,
            'size' => 27,
        ));

        return $form;
    }

}
