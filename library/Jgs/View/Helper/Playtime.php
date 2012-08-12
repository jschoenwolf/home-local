<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Playtime
 *
 * @author john
 */
class Zend_View_Helper_Playtime extends Zend_View_Helper_Abstract
{

    public function playtime($seconds)
    {

        $minutes = floor($seconds % 3600 / 60);
        $seconds = $seconds % 60;

        $time = sprintf("%01d:%02d", $minutes, $seconds);
        return $time;
    }
}
