<?php

class Application_Form_Search extends Zend_Form
{
    public function init()
    {
        $this->setMethod('POST');
        $this->setDecorators(array(
            array('ViewScript', array(
                    'viewScript' => '_searchForm.phtml'
            ))
        ));
        // create new element
        $query = $this->createElement('text', 'query');
        // element options
        $query->setLabel('Search Keywords');
        $query->setAttribs(array('placeholder' => 'Title',
            'size'        => 27,
        ));
        // add the element to the form
        $this->addElement($query);
        //submit element
        $submit = $this->createElement('submit', 'search');
        $submit->setLabel('Search Site');
        $submit->setDecorators(array('ViewHelper'));
        $this->addElement($submit);
    }
}