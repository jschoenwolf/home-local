<?php

class Admin_Form_Artist extends Zend_Form
{

    public function init()
    {
        $this->setMethod('POST');
        $this->setAttrib('id', 'artist');
        $this->setDecorators(array(
            array('ViewScript', array('viewScript' => '_artist.phtml'))
        ));

        $id = new Zend_Form_Element_hidden('id');
        $this->addElement($id);

        $name = new Zend_Form_Element_Text('name');
        $name->setLabel('Artist: ')
            ->setOptions(array('size' => 72));

        $this->addElement($name);

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Update this Artist');
        $this->addElement($submit);
    }
}
