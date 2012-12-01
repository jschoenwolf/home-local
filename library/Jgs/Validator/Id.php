<?php

/**
 * Description of Jgs_Validator_Id
 *
 * A validator designed to validate the ID property of an object that
 * extends Jgs_Model_Entity_Abstract.
 *
 * @author John Schoenwolf
 */
class Jgs_Validator_Id extends Zend_Validate_Abstract
{
    const NOT_GREATER = 'notGreaterThan';
    const NOT_LESS    = 'notLessThan';
    const NOT_DIGITS  = 'notDigits';

    /**
     * @var array
     */
    protected $_messageTemplates = array(
        self::NOT_GREATER => "Current Value ('%value%') is not greater than '0'",
        self::NOT_LESS    => "Current value ('%value%') is not less than '99999'",
        self::NOT_DIGITS  => "Field must contain only digits, current value is '%value%'."
    );

    public function isValid($value)
    {
        $this->_setValue($value);
        $isValid = true;

        if ($this->_value === '' || is_null($this->_value)) {
            return $isValid;
        }
        $digits = new Zend_Validate_Digits();
        if (!$digits->isValid($this->_value)) {
            $this->_error(self::NOT_DIGITS);
            $isValid = false;
        }
        $less    = new Zend_Validate_LessThan(array('max' => 99999));
        if (!$less->isValid($this->_value)) {
            $this->_error(self::NOT_LESS);
            $isValid = false;
        }
        $greater = new Zend_Validate_GreaterThan(array('min' => 0));
        if (!$greater->isValid($this->_value)) {
            $this->_error(self::NOT_GREATER);
            $isValid = false;
        }
        return $isValid;
    }

}
