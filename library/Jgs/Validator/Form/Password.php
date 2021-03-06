<?php

/**
 * Description of Jgs_Validator_Password
 *
 * A simple Zend Framework Form validator, used to validate form input for the
 * password field. Not to be used as a validator for the database password hash.
 *
 * @author John Schoenwolf
 */
class Jgs_Validator_Form_Password extends Zend_Validate_Abstract
{
    const LENGTH = 'length';
    const UPPER = 'upper';
    const LOWER = 'lower';
    const DIGIT = 'digit';
    const NOTEMPTY = 'empty';

    protected $_messageTemplates = array(
        self::LENGTH => "Password field must be at least 8 characters in length",
        self::UPPER  => "Password field must contain at least one uppercase letter",
        self::LOWER  => "Password field must contain at least one lowercase letter",
        self::DIGIT  => "Password field must contain at least one digit character",
    );

    /**
     *
     * @param string $value
     * @return boolean
     */
    public function isValid($value)
    {
        $this->_setValue($value);

        $isValid = true;
        $stringLength = new Zend_Validate_StringLength(array('min' => 8));
        if (!$stringLength->isValid($this->_value)) {
            $this->_error(self::LENGTH);
            $isValid = false;
        }

        if (!preg_match('/[A-Z]/', $this->_value)) {
            $this->_error(self::UPPER);
            $isValid = false;
        }

        if (!preg_match('/[a-z]/', $this->_value)) {
            $this->_error(self::LOWER);
            $isValid = false;
        }

        if (!preg_match('/\d/', $this->_value)) {
            $this->_error(self::DIGIT);
            $isValid = false;
        }
        return $isValid;
    }
}
