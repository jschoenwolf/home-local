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
     * @param string
     */
    public function __construct(Music_Model_TagInfo $taginfo)
    {
        $this->taginfo = $taginfo;
        if (is_null($this->artistMapper)) {
            $this->artistMapper = new Music_Model_Mapper_Artist();
        }
        if (is_null($this->albumMapper)) {
            $this->albumMapper = new Music_Model_Mapper_Album();
        }
        if (is_null($this->trackMapper)) {
            $this->trackMapper = new Music_Model_Mapper_Track();
        }
        $this->setArtist_id();
        $this->setAlbum_id();
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
                $value = $this->taginfo->getAlbum();
                $options = array(
                    'table'  => 'album',
                    'field'  => 'title'
                );
                break;
            case 'artist':
                $value = $this->taginfo->getArtist();
                $options = array(
                    'table'  => 'artist',
                    'field'  => 'name'
                );
                break;
            case 'track':
                $value = $this->taginfo->getMd5();
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

    public function track()
    {
        if ($this->dbNoExist('track') === TRUE) {
            $track = new Music_Model_Track(array(
                    'title'        => $this->taginfo->getTitle(),
                    'filename'     => $this->taginfo->getFilename(),
                    'path'         => $this->taginfo->getPath(),
                    'format'       => $this->taginfo->getFormat(),
                    'genre'        => $this->taginfo->getGenre(),
                    'artist'       => $this->getArtist_id(),
                    'album'        => $this->getAlbum_id(),
                    'track_number' => $this->taginfo->getTrack_number(),
                    'playtime'     => $this->taginfo->getPlaytime_seconds(),
                    'hash'         => $this->taginfo->getMd5()
                ));

            $record = $this->getTrackMapper()->saveTrack($track);
            return $record;
        } else {
            $track = $this->getTrackMapper()->findOneByColumn('hash', $this->taginfo->getMd5());
            $track->setTitle($this->taginfo->getTitle());
            $record = $this->getTrackMapper()->saveTrack($track);
        }
    }

    public function getAlbum_id()
    {
        return $this->album_id;
    }

    public function setAlbum_id()
    {
        if (is_null($this->album_id)) {
            if ($this->dbNoExist('album') === TRUE) {
                $album = new Music_Model_Album(array(
                        'title'  => $this->taginfo->getAlbum(),
                        'artist' => $this->getArtist_id(),
                        'art'    => $this->taginfo->getAlbum() . '.jpg',
                        'year'   => $this->taginfo->getYear()
                    ));

                $record = $this->getAlbumMapper()->saveAlbum($album);

                $this->album_id = $record->id;
            } else {
                $record = $this->getAlbumMapper()->findOneByColumn(
                    'title', $this->taginfo->getAlbum());

                $this->album_id = $record->id;
            }
            unset($this->albumMapper);
        }
    }

    public function getArtist_id()
    {
        return $this->artist_id;
    }

    public function setArtist_id()
    {

        if (is_null($this->artist_id)) {
            if ($this->dbNoExist('artist') === TRUE) {
                $artist = new Music_Model_Artist(array(
                        'name'  => $this->taginfo->getArtist()
                    ));
                $record = $this->getArtistMapper()->saveArtist($artist);

                $this->artist_id = $record->id;
            } else {
                $record = $this->getArtistMapper()->findOneByColumn(
                    'name', $this->taginfo->getArtist());

                $this->artist_id = $record->id;
            }
            unset($this->artistMapper);
        }
    }

    public function getAlbumMapper()
    {
        return $this->albumMapper;
    }

    public function getArtistMapper()
    {
        return $this->artistMapper;
    }

    public function getTrackMapper()
    {
        return $this->trackMapper;
    }
}
