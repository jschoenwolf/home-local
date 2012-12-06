<?php

/**
 *
 */
class Music_Model_Tag
{
    /**
     * Music_Model_TagInfo object
     */
    public $taginfo;
    /**
     * Mappers
     */
    protected $albumMapper;
    protected $artistMapper;
    protected $trackMapper;
    /**
     * Foreign Keys
     */
    public $album_id;
    public $artist_id;

    /**
     *
     * @param object Music_Model_TagInfo
     * @return boolean
     */
    public function __construct(Music_Model_TagInfo $tagInfo)
    {
        $this->taginfo = $tagInfo;

        if (is_null($this->albumMapper)) {
            $this->albumMapper = new Music_Model_Mapper_Album();
        }
        if (is_null($this->artistMapper)) {
            $this->artistMapper = new Music_Model_Mapper_Artist();
        }
        if (is_null($this->trackMapper)) {
            $this->trackMapper = new Music_Model_Mapper_Track();
        }
    }

    /**
     * Does record already exist in DB
     *
     * Pass in the mapper to use as a string.
     * Will trigger predefined validator DbNoRecordExists
     *
     * @param string $mapper accepted values are: 'album' 'artist' 'track'
     * @return boolean returns true if no record exists
     */
    protected function dbNoExist($mapper)
    {
        switch ($mapper) {
            case 'album':
                $value   = $this->taginfo->getAlbum();
                $options = array(
                    'table'  => 'album',
                    'field'  => 'title'
                );
                break;
            case 'artist':
                $value   = $this->taginfo->getArtist();
                $options = array(
                    'table'  => 'artist',
                    'field'  => 'name'
                );
                break;
            case 'track':
                $value   = $this->taginfo->getMd5();
                $options = array(
                    'table' => 'track',
                    'field' => 'hash'
                );

            default:
                break;
        }
        $validator = new Zend_Validate_Db_NoRecordExists($options);
        if ($validator->isValid($value)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function albums()
    {
        if ($this->dbNoExist('album')) {
            $album = new Music_Model_Album(array(
                    'title'  => $this->taginfo->getAlbum(),
                    'artist' => $this->artist_id,
                    'art'    => $this->taginfo->getAlbum() . '.jpg',
                    'year'   => $this->taginfo->getYear()
                ));

            $record = $this->albumMapper->saveAlbum($album);

            $this->album_id = $record->getId();
            return $record;
        } else {
            $record = $this->albumMapper->findOneByColumn(
                'title', $this->taginfo->getAlbum());

            $this->album_id = $record->getId();
            return $record;
        }
    }

    public function artists()
    {
        if ($this->dbNoExist('artist')) {
            $artist = new Music_Model_Artist(array(
                    'name'  => $this->taginfo->getArtist()
                ));
            $record = $this->artistMapper->saveArtist($artist);

            $this->artist_id = $record->getId();
            return $record;
        } else {
            $record = $this->artistMapper->findOneByColumn(
                'name', $this->taginfo->getArtist());

            $this->artist_id = $record->getId();
            return $record;
        }
    }

    public function tracks()
    {
        if ($this->dbNoExist('track')) {

            $track = new Music_Model_Track(array(
                    'title'        => $this->taginfo->getTitle(),
                    'filename'     => $this->taginfo->getFilename(),
                    'path'         => $this->taginfo->getPath(),
                    'format'       => $this->taginfo->getFormat(),
                    'genre'        => $this->taginfo->getGenre(),
                    'artist'       => $this->artist_id,
                    'album'        => $this->album_id,
                    'track_number' => $this->taginfo->getTrack_number(),
                    'playtime'     => $this->taginfo->getPlaytime_seconds(),
                    'hash'         => $this->taginfo->getMd5()
                ));

            $record = $this->trackMapper->saveTrack($track);
            return $record;
        } else {
            return $this->trackMapper->findOneByColumn(
                    'title', $this->taginfo->getTitle());
        }
    }

    public function saveTags()
    {

    }
}
