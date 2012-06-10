<?php

class Admin_Form_Album extends Zend_Form
{

    public function init() {

        $this->setMethod('POST');
        $this->setDecorators(array(
            array('ViewScript', array('viewScript' => '_album.phtml'))
        ));

        $id = new Zend_Form_Element_hidden('id');
        $this->addElement($id);

        $name = new Zend_Form_Element_Text('name');
        $name->setLabel('Album Name ')
                ->setOptions(array('size' => 62));
        $this->addElement($name);

        $art = new Zend_Form_Element_Text('art');
        $art->setLabel('Album Art')
                ->setOptions(array('size' => 62));
        $this->addElement($art);

        $year = new Zend_Form_Element_Text('year');
        $year->setLabel('Release Year')
                ->setOptions(array('size' => 62));
        $this->addElement($year);

        $artist = new Zend_Form_Element_Hidden('artist');
        $this->addElement($artist);

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Update this Album');
        $this->addElement($submit);
    }
}

