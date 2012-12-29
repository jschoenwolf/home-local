<?php

/**
 * Description of Jgs_Controller_Action_Helper_Search
 *
 * @author John Schoenwolf
 */
class Jgs_Controller_Action_Helper_Search extends Zend_Controller_Action_Helper_Abstract
{
    /**
     * @param string $action
     * @param string $label
     * @param string $placeHolder
     * @return \Application_Form_Search
     */
    public function direct($action, $label = null, $placeHolder = null)
    {
        $form = new Application_Form_Search();
        $form->setAction($action);
        $form->search->setLabel($label);
        $form->query->setAttribs(array(
            'placeholder' => $placeHolder,
            'size'        => 27,
        ));
        return $form;
    }
}
