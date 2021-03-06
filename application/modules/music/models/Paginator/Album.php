<?php

/**
 * Description of Album
 *
 * @author John Schoenwolf
 */
class Music_Model_Paginator_Album extends Zend_Paginator_Adapter_DbTableSelect
{

    public function getItems($offset, $itemCountPerPage)
    {
        $rows = parent::getItems($offset, $itemCountPerPage);

        $albums = array();
        foreach ($rows as $row) {
            $album = new Music_Model_Mapper_Album();
            $albums[] = $album->createEntity($row);
        }
        return $albums;
    }
}
