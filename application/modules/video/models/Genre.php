<?php

/**
 * Description of Video_Model_Genre
 *
 * @author John Schoenwolf
 */
class Video_Model_Genre extends Jgs_Model_Entity_Abstract
{
    protected $_name;

    public function getName() {
        return $this->_name;
    }

    public function setName($name) {
        $this->_name = $name;
        return $this;
    }
}
