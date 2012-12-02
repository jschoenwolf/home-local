<?php
/**
 * getID3() settings
 */
require_once('getid3.php');

/**
 * Class for extracting information from audio files with getID3().
 */
class Music_Model_AudioInfo extends Jgs_Model_Entity_Abstract
{
    /**
     * Private scope variables
     */
    private $result;
    private $data;
    private $getID3     = null;
    /**
     *
     * @var string path to file to scanned
     */
    protected $fileToScan;
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
    protected $track;
    protected $attachment = null;//this will be the cover art at some pont.
    protected $md5; //md5 hash data
    protected $path; //path without file name
    /**
     * 
     * @param string $file
     * @throws InvalidArgumentException
     */

    public function __construct($file, array $options = NULL)
    {
        if(is_readable($file)) {
            $this->fileToScan = $file;
        } else {
            throw new InvalidArgumentException('File not readable.');
        }
        if(is_null($this->getID3)) {
            $this->getID3 = new getID3();
        }
        $this->getInfo();

        parent::__construct($options);
    }

    public function __toString()
    {
        $vars = get_class_vars($this);
    }

    public function getInfo()
    {
        // Analyze file
        $this->data = $this->getID3->analyze($this->fileToScan);

        // Exit here on error
        if(isset($this->data['error'])) {
            return array('error' => $this->data['error']);
        }

        $this->setFilename($this->data['filename']);
        $this->setAlbum($this->data['tags_html']['id3v2']['album'][0]);
        $this->setArtist($this->data['tags_html']['id3v2']['artist'][0]);
        $this->setBitrate($this->data['bitrate']);
        $this->setFormat($this->data['fileformat']);
        $this->setGenre($this->data['tags_html']['id3v2']['genre'][0]);
        $this->setMd5($this->data['md5_data']);
        $this->setPath($this->data['filepath']);
        $this->setPlaytime_seconds($this->data['playtime_seconds']);
        $this->setPlaytime_string($this->data['playtime_string']);
        $this->setTitle($this->data['tags_html']['id3v2']['title'][0]);
        $this->setTrack($this->data['tags_html']['id3v2']['track_number'][0]);
        $this->setYear($this->data['tags_html']['id3v2']['year'][0]);
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
        $this->genre = $genre;
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

    public function getTrack()
    {
        return $this->track;
    }

    public function setTrack($track)
    {
        $this->track = $track;
        return $this;
    }

    public function getAttachment()
    {
        return $this->attachment;
    }

    public function setAttachment($attachment)
    {
        $this->attachment = $attachment;
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
