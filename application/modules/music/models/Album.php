<?php

class Music_Model_Album extends Jgs_Model_Entity_Abstract implements Jgs_Interface_Album
{
    protected $_name;
    protected $_art;
    protected $_year;
    protected $_artist;
    protected $_artistMapper = NULL;

    /**
     * Get Album Name
     *
     * @return string
     */
    public function getName() {
        return htmlspecialchars_decode($this->_name, ENT_QUOTES);
    }

    /**
     * Set Album name
     *
     * @param string $name
     * @return \Music_Model_Album
     * @throws InvalidArgumentException
     */
    public function setName($name) {
        if (!is_string($name) || strlen($name) < 2 || strlen($name) > 255) {
            throw new InvalidArgumentException(
                    "The posted 'Album Name' is invalid"
            );
        }
        $this->_name = htmlspecialchars(trim($name), ENT_QUOTES);
        return $this;
    }

    /**
     * Get filename of album art
     *
     * @return string
     */
    public function getArt() {
        return htmlspecialchars_decode($this->_art, ENT_QUOTES);
    }

    /**
     * Set filename of album art
     *
     * @param string $art
     * @return \Music_Model_Album
     * @throws InvalidArgumentException
     */
    public function setArt($art) {
        if (!is_string($art) || strlen($art) < 2 || strlen($art) > 255) {
            throw new InvalidArgumentException(
                    "The posted 'Album Image Name' is invalid"
            );
        }
        $this->_art = htmlspecialchars(trim($art), ENT_QUOTES);
        return $this;
    }

    /**
     * Get release year of Album
     *
     * @return string
     */
    public function getYear() {
        return $this->_year;
    }

    /**
     * Set release year of Album
     *
     * @param string $year
     * @return \Music_Model_Album
     * @throws InvalidArgumentException
     */
    public function setYear($year) {
        if (strlen($year) > 4) {
            throw new InvalidArgumentException(
                    "The posted value for 'Album Year' is invalid."
            );
        }
        $this->_year = $year;
        return $this;
    }

    /**
     * Get Artist object for Album
     *
     * @return \Music_Model_Artist
     */
    public function getArtist() {
        if (!is_null($this->_artist) && $this->_artist instanceof Music_Model_Artist) {
            return $this->_artist;
        } else {
            if (!$this->_artistMapper) {
                $this->_artistMapper = new Music_Model_Mapper_Artist();
            }
            return $this->_artistMapper->findById($this->getReferenceId('artist'));
        }
    }

    /**
     * Set Id of Album Artist to Reference Map
     *
     * @param string $artist
     * @return \Music_Model_Album
     */
    public function setArtist($artist) {
        $this->setReferenceId('artist', $artist);
        return $this;
    }

    /**
     * Get array of Track objects by Album Id
     * 
     * @return \Music_Model_Mappper_Track
     */
    public function getTracks() {
        $mapper = new Music_Model_Mapper_Track();
        $tracks = $mapper->findByColumn('album_id', $this->_id, 'track ASC');

        return $tracks;
    }
}

