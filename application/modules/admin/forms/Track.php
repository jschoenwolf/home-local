<?php

class Admin_Form_Track extends Zend_Form
{

    public function init()
    {
        $this->setMethod('POST');
        $this->setDecorators(array(
            array('ViewScript', array('viewScript' => '_track.phtml'))
        ));
        $this->setOptions(array('size' => 50));

        $id        = new Zend_Form_Element_Hidden('id');
        $artist    = new Zend_Form_Element_Hidden('artist');
        $album     = new Zend_Form_Element_Hidden('album');
        $format    = new Zend_Form_Element_Hidden('format');
        $hash      = new Zend_Form_Element_Hidden('hash');
        $play_time = new Zend_Form_Element_Hidden('play_time');
        $track     = new Zend_Form_Element_Hidden('track');

        $genre = new Zend_Form_Element_Text('genre');
        $genre->setLabel('Genre')
              ->setOptions(array('size' => 72));

        $path = new Zend_Form_Element_Text('path');
        $path->setLabel('Path')
             ->setOptions(array('size' => 72));

        $title = new Zend_Form_Element_Text('title');
        $title->setLabel('Title')
                ->setOptions(array('size' => 72));

        $filename = new Zend_Form_Element_Text('filename');
        $filename->setLabel('FileName')
                 ->setOptions(array('size' => 72));

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Update This Track');
        $submit->setDecorators(array('ViewHelper'));

        $this->addElements(array(
            $id, $genre, $path, $title, $submit,
            $filename, $artist, $album, $format,
            $hash, $play_time, $track
        ));
    }


}

