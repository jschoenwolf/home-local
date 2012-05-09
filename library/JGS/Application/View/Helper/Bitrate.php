<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Bitrate
 *
 * @author john
 */
class Zend_View_Helper_Bitrate extends Zend_View_Helper_Abstract
{
    public function bitrate($value) {
        return $value/1000 . ' kbps';
    }
}
