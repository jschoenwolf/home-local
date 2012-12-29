<?php

/**
 * Description of Jgs_Validator_Form_Email.
 * Validate an Email address.
 *
 * @author John Schoenwolf
 */
class Jgs_Validator_Form_Email extends Zend_Validate_Abstract
{
    const EMAIL = 'email';

    protected $_messageTeplates = array(
        self::EMAIL => "'%value%' is not a valid email address."
    );

    public function isValid($value)
    {
        $this->_setValue($value);

        $isValid = true;

        $pattern = ('/^[\w-]+(\.[\w-]+)*@([a-z0-9-]+(\.[a-z0-9-]+)*?\.[a-z]{2,6}|(\d{1,3}\.){3}\d{1,3})(:\d{4})?$/');

        if (!preg_match($pattern, $value)) {
            $this->_error(self::EMAIL);
            $isValid = false;
        }
        return $isValid;
    }
}
