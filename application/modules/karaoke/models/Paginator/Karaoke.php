<?php

/**
 * Description of Karaoke_Model_Paginator_Karaoke
 *
 * @author John Schoenwolf
 */
class Karaoke_Model_Paginator_Karaoke extends Zend_Paginator_Adapter_DbTableSelect
{

    public function getItems($offset, $itemCountPerPage)
    {
        $rows = parent::getItems($offset, $itemCountPerPage);

        $karaoke = array();
        foreach ($rows as $row) {
            $track = new Karaoke_Model_Mapper_Karaoke();
            $karaoke[] = $track->createEntity($row);
        }
        return $karaoke;
    }
}
