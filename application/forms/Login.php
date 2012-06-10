<?php

class Application_Form_Login extends Zend_Form
{

    public function init() {
        $this->setMethod('POST');

        $id = new Zend_Form_Element_Hidden('id');

        $name = new Zend_Form_Element_Text('name');
        $name->setLabel('Name');
        $name->addFilters(array(
                 'StringTrim', 'StripTags', 'HtmlEntities'
             ))
             ->setRequired(TRUE)
             ->addValidator('Alnum', FALSE, array(
                 'allowWhiteSpace' => TRUE
             ));
        $name->addErrorMessage('Your name is required.');

        $password = new Zend_Form_Element_Password('password');
        $password->setLabel('Password');
        $password->setRequired('TRUE')
                 ->addValidator('StringLength', array('min' => 8, 'max' => 64))
                 ->addFilters(array(
                    'StringTrim', 'StripTags', 'HtmlEntities'
                ));


        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Login');

        $this->addElements($id, $name, $password, $submit);
    }
}

