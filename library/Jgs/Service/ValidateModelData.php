<?php

/**
 * Description of Jgs_Service_ValidateModelData
 *
 * A collection of filters and validators used to validate and filter data
 * prior to persisting in a database or other storage media.
 *
 * @author John Schoenwolf
 */
class Jgs_Service_ValidateModelData
{

    public function isIdValid($id)
    {
        $data = array('id' => $id);
        $filters = array(
            'id' => array(
                'StringTrim', 'StripTags', 'HtmlEntities', 'Digits'
            )
        );
        $validators = array(
            'id' => 'Int',
            'id' => new Zend_Validate_GreaterThan(array('min' => 1))
        );
        $input = new Zend_Filter_Input($validators, $filters, $data);
        if ($input->isValid()) {
            return true;
        } else {
            return $input->getMessages();
        }
    }
}
