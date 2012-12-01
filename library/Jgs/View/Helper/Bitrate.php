<?php

/**
 * Description of Bitrate
 *
 * @author John schoenwolf
 */
class Zend_View_Helper_Bitrate extends Zend_View_Helper_Abstract
{
    /**
     *
     * @param type $value
     * @return string
     */
    public function bitrate($value)
    {
        return $value / 1000 . ' kbps';
    }

}
