<?php

/**
 * Description of Karaoke
 *
 * @author John Schoenwolf
 */
class Karaoke_Model_Karaoke extends Jgs_Model_Entity_Abstract
{
    protected $title;
    protected $artist;
    protected $manu;
    protected $disc;
    protected $track;

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    public function getArtist()
    {
        return $this->artist;
    }

    public function setArtist($artist)
    {
        $this->artist = $artist;
        return $this;
    }

    public function getManu()
    {
        return $this->manu;
    }

    public function setManu($manu)
    {
        $this->manu = $manu;
        return $this;
    }

    public function getDisc()
    {
        return $this->disc;
    }

    public function setDisc($disc)
    {
        $this->disc = $disc;
        return $this;
    }

    public function getTrack()
    {
        return $this->track;
    }

    public function setTrack($track)
    {
        $this->track = $track;
        return $this;
    }
}
