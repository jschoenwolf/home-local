<?php

/**
 * Description of StringToArray
 *
 * @author john
 */
class Zend_View_Helper_StringToArray extends Zend_View_Helper_Abstract
{
    /**
     *
     * @param type $delimiter
     * @param type $string
     * @return string
     */
    public function stringToArray($delimiter, $string)
    {

        $utilities = new Jgs_Utilities();
        $string    = trim($string, '[]');
        $explode   = explode($delimiter, $string);
        $array     = $utilities->arrayTrim($explode);

        return $array;
    }

}
