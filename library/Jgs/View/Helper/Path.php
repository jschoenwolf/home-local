<?php

/**
 * Description of Path
 *
 * @author john
 */
class Zend_View_Helper_Path extends Zend_View_Helper_Abstract
{
    /**
     *
     * @param type $path
     * @return string
     */
    public function path($path)
    {
        $seg  = explode('\\', $path);
        $nseg = array_shift($seg);
        $mseg = array_shift($seg);

        $result = implode('/', $seg);
        return '/' . $result;
    }

}
