<?php

/**
 * Description of Artist
 *
 * @author John Schoenwolf
 */
class Music_Model_Mapper_Artist extends Jgs_Application_Model_Mapper
{
    protected $_tableName = 'artist';


    public function save(Music_Model_Artist $artist) {
        if (is_null($artist->id)) {

        }
    }
    protected function createEntity($row) {
        
    }

}
