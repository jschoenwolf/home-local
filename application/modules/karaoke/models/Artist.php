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
class Karaoke_Model_Artist extends Jgs_Model_Entity_Abstract {

    protected $artist;

    public function getArtist() {
        return $this->artist;
    }

    public function setArtist($artist) {
        $this->artist = $artist;
        return $this;
    }

}
