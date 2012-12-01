<?php

/**
 * Description of Zend_View_Helper_Abstract
 *
 * @author John Schoenwolf
 */
class Zend_View_Helper_PadId extends Zend_View_Helper_Abstract
{
    /**
     *
     * @param type $id
     * @return string
     */
    public function padId($id)
    {
        return str_pad($id, 5, 0, STR_PAD_LEFT);
    }

}
