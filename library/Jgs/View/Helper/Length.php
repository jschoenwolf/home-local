<?php

/**
 * Description of Length
 *
 * @author john
 */
class Zend_View_Helper_Length extends Zend_View_Helper_Abstract
{
    /**
     *
     * @param type $minutes
     * @return string
     */
    public function length($minutes)
    {
        $hours   = floor($minutes / 60);
        $minutes = $minutes % 60;

        if ($hours > 0) {
            $time = sprintf("%01d Hours %02d Minutes", $hours, $minutes);
        } else {
            $time = sprintf("%02d Minutes", $minutes);
        }
        return $time;
    }

}
