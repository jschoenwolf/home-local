<?php

class Application_Form_User extends Zend_Form
{
    public function init()
    {
        $this->setMethod('POST');
        //default filters
        $filters = array('StringTrim', 'StripTags', 'HtmlEntities');
        //id element
        $id = $this->createElement('hidden', 'id');
        $id->setDecorators(array('ViewHelper'));
        $this->addElement($id);
        //name element
        $name = new Zend_Form_Element_Text('name');
        $name->setLabel('Name');
        $name->setAttrib('placeholder', 'Username');
        $name->setOptions(array('size' => 20));
        $name->addFilters($filters);
        $name->addFilter('StringToLower');
        $name->setRequired(TRUE);
        $name->addValidator('Alpha', FALSE, array(
            'allowWhiteSpace' => TRUE
        ));
        $name->addValidator(new Zend_Validate_Db_NoRecordExists(array(
                'table' => 'users',
                'field' => 'name'
            )));
        $this->addElement($name);
        //password element
        $password = new Zend_Form_Element_Password('password');
        $password->setLabel('Password');
        $password->setAttrib('placeholder', 'Password');
        $password->setOptions(array('size' => 20));
        $password->setRequired(TRUE);
        $password->addValidator(new Jgs_Validator_Form_Password());
        $password->addFilters($filters);
        $this->addElement($password);
        //second password element
        $passRep = new Zend_Form_Element_Password('passRep');
        $passRep->setLabel('Re-enter Password');
        $passRep->setAttrib('placeholder', 'Re-enter Password');
        $passRep->setOptions(array('size' => 20));
        $passRep->setRequired(TRUE);
        $passRep->addValidator(new Zend_Validate_Identical(array('token' => 'password')));
        $passRep->addFilters($filters);
        $this->addElement($passRep);
        //role element
        $role = $this->createElement('select', 'role');
        $role->setLabel("Select a role: ")
            ->addMultiOption('user', 'User')
            ->addMultiOption('administrator', 'Administrator');
        $this->addElement($role);
        //submit element
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Register');
        $submit->removeDecorator('HtmlTag');
        $submit->removeDecorator('DtDdWrapper');
        $this->addElement($submit);
    }
}
