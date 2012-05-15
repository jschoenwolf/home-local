<?php

/**
 * Description of Album
 *
 * @author John Schoenwolf
 */
interface Jgs_Application_Interface_Album
{

    public function setId($id);
    public function getId();

    public function setName($name);
    public function getName();

    public function setArt($art);
    public function getArt();

    public function setYear($year);
    public function getYear();

    public function setArtist($artist);
    public function getArtist();
}
