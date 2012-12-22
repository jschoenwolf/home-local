<?php

/**
 * Class for extracting information from audio files with getID3().
 */
class Music_Model_TagInfo extends Jgs_Model_Entity_Abstract
{
    /**
     * data to be extracted and forwarded.
     */
    protected $album;
    protected $artist;
    protected $bitrate; //example 113485.71 /1000 for kbps
    protected $title;
    protected $filename; //filename without path info
    protected $format; //example .mp3 alias of file extension
    protected $genre;
    protected $playtime_string; //example 3:45 minutes:seconds
    protected $playtime_seconds; //example 225.13 seconds
    protected $year;
    protected $track_number;
    protected $md5; //md5 hash data
    protected $path; //path without file name

    /**
     *
     * @param string $file
     * @throws InvalidArgumentException
     */

    public function __construct(array $options = NULL)
    {
        parent::__construct($options);
    }

    public function getAlbum()
    {
        return $this->album;
    }

    public function setAlbum($album)
    {
        $this->album = utf8_encode(strtolower(trim($album)));
        return $this;
    }

    public function getArtist()
    {
        return $this->artist;
    }

    public function setArtist($artist)
    {
        $this->artist = utf8_encode(strtolower(trim($artist)));
        return $this;
    }

    public function getBitrate()
    {
        return $this->bitrate;
    }

    public function setBitrate($bitrate)
    {
        $this->bitrate = $bitrate;
        return $this;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = utf8_encode(strtolower(trim($title)));
        return $this;
    }

    public function getFilename()
    {
        return $this->filename;
    }

    public function setFilename($filename)
    {
        $this->filename = utf8_encode($filename);
        return $this;
    }

    public function getFormat()
    {
        return $this->format;
    }

    public function setFormat($format)
    {
        $this->format = $format;
        return $this;
    }

    public function getGenre()
    {
        return $this->genre;
    }

    public function setGenre($genre)
    {
        $this->genre = strtolower(trim($genre));
        return $this;
    }

    public function getPlaytime_string()
    {
        return $this->playtime_string;
    }

    public function setPlaytime_string($playtime_string)
    {
        $this->playtime_string = $playtime_string;
        return $this;
    }

    public function getPlaytime_seconds()
    {
        return $this->playtime_seconds;
    }

    public function setPlaytime_seconds($playtime_seconds)
    {
        $this->playtime_seconds = $playtime_seconds;
        return $this;
    }

    public function getYear()
    {
        return $this->year;
    }

    public function setYear($year)
    {
        $this->year = $year;
        return $this;
    }

    public function getTrack_number()
    {
        return $this->track_number;
    }

    public function setTrack_number($track)
    {
        $this->track_number = (int)$track;
        return $this;
    }

    public function getMd5()
    {
        return $this->md5;
    }

    public function setMd5($md5)
    {
        $this->md5 = $md5;
        return $this;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function setPath($path)
    {
        $this->path = $path;
        return $this;
    }
}
