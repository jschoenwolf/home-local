<?php

/**
 * Description of Jgs_Validator_Form_Usphone.
 * Validate a U.S. Phone number pattern
 *
 * @author john
 */
class Jgs_Validator_Form_Usphone extends Zend_Validate_Abstract
{
    const PHONE = 'phone';

    protected $_messageTemplates = array(
        self::PHONE => "'%value%' is not a valid U.S. phone number.
            Phone number must be entered in (xxx)xxx-xxxx or xxx-xxx-xxxx format."
    );

    public function isValid($value)
    {
        $this->_setValue($value);

        $isValid = true;
        $pattern = ('/^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/');
        if (!preg_match($pattern, $value)) {
            $this->_error(self::PHONE);
            $isValid = false;
        }
        return $isValid;
    }
}