<?php

class Application_Form_Music extends Zend_Form
{
    public function init()
    {
        $this->setMethod('post');
        $this->setAttrib('enctype', 'multipart/form-data');
        $this->setDecorators(array(
            array('ViewScript', array('viewScript' => '_file.phtml'))
        ));

        $files = new Zend_Form_Element_File('file');
        $files->setLabel('Select file to scan: ')
            ->setOptions(array('size' => 40))
            ->setDestination(APPLICATION_PATH . '\\..\\data\\')
            ->removeDecorator('HtmlTag');
        $files->addValidator('Count', FALSE, 1);
        $files->addValidator('Extension', FALSE, 'csv,txt,xml');
        $files->addValidator('Size', FALSE, array(
            'min'        => '1kB',
            'max'        => '10MB',
            'bytestring' => TRUE
        ));
        $this->addElement($files);

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Scan');
        $this->addElement($submit);
    }
}
