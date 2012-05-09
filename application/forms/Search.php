<?php

class Application_Form_Search extends Zend_Form
{

    public function init() {

        // create new element
        $query = $this->createElement('text', 'query');
        // element options
        $query->setLabel('Search Keywords');
        $query->setAttribs(array('placeholder' => 'Artist or Title',
            'size' => 27,
            ));
        // add the element to the form
        $this->addElement($query);

        $submit = $this->createElement('submit', 'search');
        $submit->setLabel('Search Site');
        $submit->setDecorators(array('ViewHelper'));
        $this->addElement($submit);
    }
}

