<?php

/**
 *
 * @author john
 */
interface Jgs_Interface_Track
{

    public function setId($id);

    public function getId();

    public function setTitle($title);

    public function getTitle();

    public function setFilename($filename);

    public function getFilename();

    public function setPath($path);

    public function getPath();

    public function setFormat($format);

    public function getFormat();

    public function setGenre($genre);

    public function getGenre();

    public function setTrack($track);

    public function getTrack();

    public function setHash($hash);

    public function getHash();

    public function setPlay_time($play_time);

    public function getPlay_time();

    public function setArtist($artist);

    public function getArtist();

    public function setAlbum($album);

    public function getAlbum();
}
