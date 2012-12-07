<?php

class Music_Model_Album extends Jgs_Model_Entity_Abstract
{
    protected $title;
    protected $art;
    protected $year;
    protected $artist;
    protected $artistMapper = null;

    /**
     * Get Album Name
     *
     * @return string
     */
    public function getTitle() {
        return htmlspecialchars_decode($this->title, ENT_QUOTES);
    }

    /**
     * Set Album name
     *
     * @param string $title
     * @return \Music_Model_Album
     * @throws InvalidArgumentException
     */
    public function setTitle($title) {
        if (!is_string($title) || strlen($title) < 2 || strlen($title) > 255) {
            throw new InvalidArgumentException(
                    "The posted 'Album Name' is invalid"
            );
        }
        $this->title = htmlspecialchars(trim($title), ENT_QUOTES);
        return $this;
    }

    /**
     * Get filename of album art
     *
     * @return string
     */
    public function getArt() {
        return htmlspecialchars_decode($this->art, ENT_QUOTES);
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
        $this->art = htmlspecialchars(trim($art), ENT_QUOTES);
        return $this;
    }

    /**
     * Get release year of Album
     *
     * @return string
     */
    public function getYear() {
        return $this->year;
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
        $this->year = $year;
        return $this;
    }

    /**
     * Get Artist object for Album
     *
     * @return \Music_Model_Artist
     */
    public function getArtist() {
        if (!is_null($this->artist) && $this->artist instanceof Music_Model_Artist) {
            return $this->artist;
        } else {
            if (!$this->artistMapper) {
                $this->artistMapper = new Music_Model_Mapper_Artist();
            }
            return $this->artistMapper->findById($this->getReferenceId('artist'));
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
        $tracks = $mapper->findByColumn('album_id', $this->id, 'track_number ASC');

        return $tracks;
    }
}

