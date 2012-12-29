<?php

class Music_Model_Artist extends Jgs_Model_Entity_Abstract implements Jgs_Interface_Artist
{
    /**
     * Artist Name
     *
     * @var string
     */
    protected $name;

    /**
     * Get Artist name as string.
     *
     * @return string
     */
    public function getName()
    {
        return htmlspecialchars_decode($this->name, ENT_QUOTES);
    }

    /**
     * Set Artist name as string.
     *
     * @param type $name
     * @return \Music_Model_Artist
     * @throws InvalidArgumentException
     */
    public function setName($name)
    {
        if (!is_string($name) || strlen($name) < 2 || strlen($name) > 255) {
            throw new InvalidArgumentException(
                "The posted value ($name) for 'Artist Name' is invalid"
            );
        }

        $this->name = htmlspecialchars(trim($name), ENT_QUOTES);
        return $this;
    }

    /**
     * Returns an array of Albums from the Artist id.
     *
     * @return \Music_Model_Mapper_Album
     */
    public function getAlbums()
    {
        $mapper = new Music_Model_Mapper_Album();
        $albums = $mapper->findByColumn('artist_id', $this->id);

        return $albums;
    }

    /**
     * Returns an array of Track Objects by Artist id.
     *
     * @return \Music_Model_Mapper_Track
     */
    public function getTracks()
    {
        $mapper = new Music_Model_Mapper_Track();
        $tracks = $mapper->findByColumn('artist_id', $this->id);

        return $tracks;
    }
}
