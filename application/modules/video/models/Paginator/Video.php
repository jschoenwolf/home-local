<?php

/**
 * Description of Video_Model_Paginator_Video
 * paginator adapter.
 *
 * @author john
 */
class Video_Model_Paginator_Video extends Zend_Paginator_Adapter_DbTableSelect
{

    public function getItems($offset, $itemCountPerPage)
    {
        $rows = parent::getItems($offset, $itemCountPerPage);

        $videos = array();
        foreach ($rows as $row) {
            $video = new Video_Model_Mapper_Video();
            $videos[] = $video->createEntity($row);
        }
        return $videos;
    }
}
