<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Artist
 *
 * @author John
 */
class Karaoke_Model_Paginator_Artist extends Zend_Paginator_Adapter_DbTableSelect {

    public function getItems($offset, $itemCountPerPage) {
        $rows = parent::getItems($offset, $itemCountPerPage);

        $artist = array();
        foreach ($rows as $row) {
            $track = new Karaoke_Model_Mapper_Artist();
            $artist[] = $track->createEntity($row);
        }
        return $artist;
    }

}
