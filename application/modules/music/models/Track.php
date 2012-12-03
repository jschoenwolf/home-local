<?php

class Music_Model_Track extends Jgs_Model_Entity_Abstract implements Jgs_Interface_Track
{
    protected $album;
    protected $artist;
    protected $filename;
    protected $format;
    protected $genre;
    protected $hash;
    protected $path;
    protected $playtime;
    protected $title;
    protected $track_number;
    protected $albumMapper  = null;
    protected $artistMapper = null;

    public function getAlbum()
    {
        if(!is_null($this->album) && $this->album instanceof Music_Model_Album) {
            return $this->album;
        } else {
            if(!$this->albumMapper) {
                $this->albumMapper = new Music_Model_Mapper_Album();
            }
            return $this->albumMapper->findById($this->getReferenceId('album'));
        }
    }

    public function getArtist()
    {
        if(!is_null($this->artist) && $this->artist instanceof Music_Model_Artist) {
            return $this->artist;
        } else {
            if(!$this->artistMapper) {
                $this->artistMapper = new Music_Model_Mapper_Artist();
            }
            return $this->artistMapper->findById($this->getReferenceId('artist'));
        }
    }

    public function getFilename()
    {
        return $this->filename;
    }

    public function getFormat()
    {
        return $this->format;
    }

    public function getGenre()
    {
        return $this->genre;
    }

    public function getHash()
    {
        return $this->hash;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function getPlaytime()
    {
        return $this->playtime;
    }

    public function getTitle()
    {
        return ucwords($this->title);
    }

    public function getTrack_number()
    {
        return $this->track_number;
    }

    public function setAlbum($album)
    {
        $this->setReferenceId('album', $album);
        return $this;
    }

    public function setArtist($artist)
    {
        $this->setReferenceId('artist', $artist);
        return $this;
    }

    public function setFilename($filename)
    {
        $this->filename = $filename;
        return $this;
    }

    public function setFormat($format)
    {
        $this->format = $format;
        return $this;
    }

    public function setGenre($genre)
    {
        $this->genre = $genre;
        return $this;
    }

    public function setHash($hash)
    {
        $this->hash = $hash;
        return $this;
    }

    public function setPath($path)
    {
        $this->path = $path;
        return $this;
    }

    public function setPlaytime($play_time)
    {
        $this->playtime = $play_time;
        return $this;
    }

    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    public function setTrack_number($track)
    {
        $this->track_number = $track;
        return $this;
    }
}
