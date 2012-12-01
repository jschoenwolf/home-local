<?php

/**
 *
 */
class Music_Model_Tag
{
    protected $album;
    protected $artist;
    protected $bitrate;
    protected $title;
    protected $filename;
    protected $format;
    protected $genre;
    protected $play_time;
    protected $year;
    protected $track;
    protected $art = null;
    protected $hash;
    protected $path;

    /**
     *
     * @param array $options
     */
    public function __construct(array $options = null)
    {

        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    /**
     *
     * @param array $options
     * @return \Application_Model_Tag
     */
    public function setOptions(array $options)
    {

        /* @var $methods Application_Model_Tag */
        $methods = get_class_methods($this);

        foreach ($options as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (in_array($method, $methods)) {
                $this->$method($value);
            }
        }
        return $this;
    }

    /**
     *
     * @param type $name
     * @param type $value
     * @throws Zend_Exception
     */
    public function __set($name, $value)
    {
        $method = 'set' . $name;
        if (!method_exists($this, $method)) {
            throw new Zend_Exception('Invalid Tag Property');
        }
        $this->$method($value);
    }

    /**
     *
     * @param type $name
     * @return type
     * @throws Zend_Exception
     */
    public function __get($name)
    {
        $method = 'get' . $name;
        if (!method_exists($this, $method)) {
            throw new Zend_Exception('Invalid Tag Property');
        }
        return $this->$method();
    }

    public function saveTags()
    {

        $trackMapper  = new Music_Model_Mapper_Track();
        $artistMapper = new Music_Model_Mapper_Artist();
        $albumMapper  = new Music_Model_Mapper_Album();

        if (isset($this->hash)) {
            //see if track already exists by comparing hashs
            $trackRow = $trackMapper->fetchByColumn('hash', $this->getHash());
            //if track does not exist
            if (is_null($trackRow)) {
                //save the artist
                $artistData = array(
                    'name'     => $this->getArtist()
                );
                //see it the artist exists by name
                $artistRow = $artistMapper->fetchByColumn('name', $this->getArtist());
                //does artist exist?
                if (is_null($artistRow)) {
                    $artistRow = $artistMapper->save($artistData);
                }

                //Save the Album Data
                //does the album exist?
                $albumRow = $albumMapper->fetchByColumn('name', $this->getAlbum());
                //if yes
                if (is_null($albumRow)) {
                    $albumData = array(
                        'name'      => $this->getAlbum(),
                        'artist_id' => $artistRow->id,
                        'art'       => $this->getAlbum() . '.jpg',
                        'year'      => $this->getYear()
                    );
                    //get album row
                    $albumRow   = $albumMapper->save($albumData);
                }
                //Save track data
                $trackData  = array(
                    'title'     => $this->getTitle(),
                    'filename'  => $this->getFilename(),
                    'path'      => $this->getPath(),
                    'format'    => $this->getFormat(),
                    'genre'     => $this->getGenre(),
                    'artist_id' => $artistRow->id,
                    'album_id'  => $albumRow->id,
                    'track'     => $this->getTrack(),
                    'play_time' => $this->getPlay_time(),
                    'hash'      => $this->getHash()
                );
                //save track data
                $trackMapper->save($trackData);
            }
        } else {
            return;
        }
    }

    public function getAlbum()
    {
        return $this->album;
    }

    public function setAlbum($album)
    {
        $this->album = $album;
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
        $this->title = $title;
        return $this;
    }

    public function getFilename()
    {
        return $this->filename;
    }

    public function setFilename($filename)
    {
        $this->filename = $filename;
        return $this;
    }

    public function getFormat()
    {
        return $this->format;
    }

    public function setFormat($file_format)
    {
        $this->format = $file_format;
        return $this;
    }

    public function getPlay_time()
    {
        return $this->play_time;
    }

    public function setPlay_time($playtime)
    {
        $this->play_time = $playtime;
        return $this;
    }

    public function getYear()
    {
        return $this->year;
    }

    public function setYear($year)
    {
        $this->year = (int) $year;
        return $this;
    }

    public function getTrack()
    {
        return $this->track;
    }

    public function setTrack($track)
    {
        $this->track = (int) $track;
        return $this;
    }

    public function getArt()
    {
        return $this->art;
    }

    public function setArt($art)
    {
        $this->art = $art;
        return $this;
    }

    public function getHash()
    {
        return $this->hash;
    }

    public function setHash($hash)
    {
        $this->hash = $hash;
        return $this;
    }

    public function getGenre()
    {
        return $this->genre;
    }

    public function setGenre($genre)
    {
        $this->genre = $genre;
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
