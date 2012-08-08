<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of StringToArray
 *
 * @author john
 */
class Zend_View_Helper_StringToArray extends Zend_View_Helper_Abstract
{

    public function stringToArray($delimiter, $string) {

        $utilities = new JGS_Application_Utilities();
        $string = trim($string, '[]');
        $explode = explode($delimiter, $string);
        $array = $utilities->arrayTrim($explode);

        return $array;
    }
}
