<?php

class Application_Form_Login extends Zend_Form
{
    public function init()
    {
        /**
         * set POST method for form
         */
        $this->setMethod('POST');
        //set default action
        $this->setAction('/index/login');
        /**
         * Set the viewScript decorator
         */
        $this->setDecorators(array(
            array('ViewScript', array(
                    'viewScript' => '_login.phtml'
            ))
        ));
        /**
         * Set standard filters for all elements
         */
        $filters = array('StringTrim', 'StripTags', 'HtmlEntities');
        /**
         * Text element 'name'
         */
        $name = new Zend_Form_Element_Text('name');
        $name->setLabel('Name');
        $name->setAttrib('placeholder', 'Username');
        $name->setOptions(array('size' => 20));
        $name->addFilters($filters);
        $name->addFilter('StringToLower');
        $name->setRequired(true);
        $name->addValidator('Alpha', false, array(
            'allowWhiteSpace' => true
        ));
        $name->addErrorMessage('Your name is required.');
        $name->removeDecorator('HtmlTag');
        /**
         * Password element for 'password'
         */
        $password = new Zend_Form_Element_Password('password');
        $password->setLabel('Password');
        $password->setAttrib('placeholder', 'Password');
        $password->setOptions(array('size' => 20));
        $password->setRequired('true');
        $password->addValidator(new Jgs_Validator_Form_Password());
        $password->addFilters($filters);
        $password->removeDecorator('HtmlTag');
        /**
         * submit button
         */
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Login');
        $submit->removeDecorator('HtmlTag');
        $submit->removeDecorator('DtDdWrapper');
        /**
         * add all elements to the form
         */
        $this->addElements(array($name, $password, $submit));
    }
}