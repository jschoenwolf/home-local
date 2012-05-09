<?php

/**
 *
 */
class Application_Model_Tag
{
    protected $_album;
    protected $_artist;
    protected $_bitrate;
    protected $_title;
    protected $_filename;
    protected $_format;
    protected $_genre;
    protected $_play_time;
    protected $_year;
    protected $_track;
    protected $_art = null;
    protected $_hash;
    protected $_path;

    /**
     *
     * @param array $options
     */
    public function __construct(array $options = NULL) {

        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    /**
     *
     * @param array $options
     * @return \Application_Model_Tag
     */
    public function setOptions(array $options) {

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
    public function __set($name, $value) {
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
    public function __get($name) {
        $method = 'get' . $name;
        if (!method_exists($this, $method)) {
            throw new Zend_Exception('Invalid Tag Property');
        }
        return $this->$method();
    }

    public function saveTags() {

        $trackGateway = new Application_Model_DbTable_Track();
        $artistGateway = new Application_Model_DbTable_Artist();
        $albumGateway = new Application_Model_DbTable_Album();

        if (isset($this->_hash)) {

            //see if track already exists by comparing hashs
            $trackRow = $trackGateway->fetchTrackRow('hash', $this->getHash());

            //if track does not exist
            if (!$trackRow) {
                //save the artist
                $artistData = array(
                    'name' => $this->getArtist()
                );
                //see it the artist exists by name
                $artistRow = $artistGateway->fetchArtistRow('name', $this->getArtist());
                //does artist exist?
                if (!$artistRow) {
                    $artistRow = $artistGateway->saveArtist($artistData);
                }

                //Save the Album Data
                //does the album exist?
                $albumRow = $albumGateway->fetchAlbumRow('name', $this->getAlbum());
                //if yes
                if (!$albumRow) {

                    $albumData = array(
                        'name' => $this->getAlbum(),
                        'artist_id' => $artistRow->id,
                        'art' => $this->getAlbum() . '.jpg',
                        'year' => $this->getYear()
                    );
                    //get album row
                    $albumRow = $albumGateway->saveAlbum($albumData);
                }

                //Save track data
                $trackData = array(
                    'title' => $this->getTitle(),
                    'filename' => $this->getFilename(),
                    'path' => $this->getPath(),
                    'format' => $this->getFormat(),
                    'genre' => $this->getGenre(),
                    'artist_id' => $artistRow->id,
                    'album_id' => $albumRow->id,
                    'track' => $this->getTrack(),
                    'play_time' => $this->getPlay_time(),
                    'hash' => $this->getHash()
                );
                //save track data
                $trackGateway->saveTrack($trackData);
            }
        } else {
            return;
        }
    }

    public function getAlbum() {
        return $this->_album;
    }

    public function setAlbum($album) {
        $this->_album = $album;
        return $this;
    }

    public function getArtist() {
        return $this->_artist;
    }

    public function setArtist($artist) {
        $this->_artist = $artist;
        return $this;
    }

    public function getBitrate() {
        return $this->_bitrate;
    }

    public function setBitrate($bitrate) {
        $this->_bitrate = $bitrate;
        return $this;
    }

    public function getTitle() {
        return $this->_title;
    }

    public function setTitle($title) {
        $this->_title = $title;
        return $this;
    }

    public function getFilename() {
        return $this->_filename;
    }

    public function setFilename($filename) {
        $this->_filename = $filename;
        return $this;
    }

    public function getFormat() {
        return $this->_format;
    }

    public function setFormat($file_format) {
        $this->_format = $file_format;
        return $this;
    }

    public function getPlay_time() {
        return $this->_play_time;
    }

    public function setPlay_time($playtime) {
        $this->_play_time = $playtime;
        return $this;
    }

    public function getYear() {
        return $this->_year;
    }

    public function setYear($year) {
        $this->_year = (int) $year;
        return $this;
    }

    public function getTrack() {
        return $this->_track;
    }

    public function setTrack($track) {
        $this->_track = (int) $track;
        return $this;
    }

    public function getArt() {
        return $this->_art;
    }

    public function setArt($art) {
        $this->_art = $art;
        return $this;
    }

    public function getHash() {
        return $this->_hash;
    }

    public function setHash($hash) {
        $this->_hash = $hash;
        return $this;
    }

    public function getGenre() {
        return $this->_genre;
    }

    public function setGenre($genre) {
        $this->_genre = $genre;
        return $this;
    }

    public function getPath() {
        return $this->_path;
    }

    public function setPath($path) {
        $this->_path = $path;
        return $this;
    }
}

