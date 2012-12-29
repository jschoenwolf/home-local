<?php

/**
 * Description of Video_Model_Genre
 *
 * @author John Schoenwolf
 */
class Video_Model_Genre extends Jgs_Model_Entity_Abstract
{
    protected $name;

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
}
