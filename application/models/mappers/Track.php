<?php

/**
 * Description of Application_Model_Mapper_Track
 *
 * @author John Schoenwolf
 */
class Application_Model_Mapper_Track extends Jgs_Application_Model_Mapper
{
    /**
     * Name of database table as a string.
     *
     * @var string $_tableName
     */
    protected $_tableName = 'track';
    /**
     * Name of entity model class as a string.
     *
     * @var string $_entityClass
     */
    protected $_entityClass = 'Application_Model_Track';

    public function __construct(Zend_Db_Table_Abstract $tableGateway = NULL) {
        $this->_tableGateway = new Application_Model_DbTable_Track();
        parent::__construct($tableGateway);
    }

    /**
     * Find a single row in the database table.
     *
     * @param string $id
     * @return Application_Model_Track
     */
    public function find($id) {
        if ($this->_getIdentity($id)) {
            return $this->_getIdentity($id);
        }
        $select = $this->_select;
        $select->where('id = ?', $id);
        $row = $this->_getGateway()->fetchRow($select);
        if (is_null($row)) {
            return NULL;
        } else {
            $track = new $this->_entityClass(array(
                        'id'        => $row->id,
                        'title'     => $row->title,
                        'filename'  => $row->filename,
                        'path'      => $row->path,
                        'format'    => $row->format,
                        'genre'     => $row->genre,
                        'track'     => $row->track,
                        'hash'      => $row->hash,
                        'play_time' => $row->play_time
                    ));
            $track->setReferenceId('artist', $row->artist_id);
            $track->setReferenceId('album', $row->album_id);
            $this->_setIdentity($id, $track);

            return $track;
        }
    }


    /**
     * Insert or update a single row in database.
     *
     * @param Application_Model_Track $track
     */
    public function save(Application_Model_Track $track) {

        if ((!$track->id)) {
            $data = array(
                'title'     => $track->title,
                'filename'  => $track->filename,
                'path'      => $track->path,
                'format'    => $track->format,
                'genre'     => $track->genre,
                'track'     => $track->track,
                'hash'      => $track->hash,
                'play_time' => $track->play_time,
                'artist_id' => $track->artist->id,
                'album_id'  => $track->album->id
            );
            $track->id = $this->_getGateway()->insert($data);
            $this->_setIdentity($track->id, $track);
        } else {
            $data = array(
                'id'        => $track->id,
                'title'     => $track->title,
                'filename'  => $track->filename,
                'path'      => $track->path,
                'format'    => $track->format,
                'genre'     => $track->genre,
                'track'     => $track->track,
                'hash'      => $track->hash,
                'play_time' => $track->play_time,
                'artist_id' => $track->artist->id,
                'album_id'  => $track->album->id
            );
            $where = $this->_getGateway()->getAdapter()
                    ->quoteInto('id = ?', $track->id);
            $this->_getGateway()->update($data, $where);
        }
    }

    public function fetchAll() {
        $result = $this->_getGateway()->fetchAll();
        $tracks = array();
        foreach ($result as $row) {
            $track = new $this->_entityClass(array(
                        'id'        => $row->id,
                        'title'     => $row->title,
                        'filename'  => $row->filename,
                        'path'      => $row->path,
                        'format'    => $row->format,
                        'genre'     => $row->genre,
                        'track'     => $row->track,
                        'hash'      => $row->hash,
                        'play_time' => $row->play_time
                    ));
            $track->setReferenceId('artist', $row->artist_id);
            $track->setReferenceId('album', $row->album_id);
            $tracks[] = $track;
        }
        return $tracks;
    }

    /**
     *
     * @return \Zend_Paginator_Adapter_DbTableSelect
     */
    public function fetchPagedTracks($artist = NULL, $query = NULL) {

        $select = $this->_getGateway()
                       ->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
                       ->setIntegrityCheck(FALSE);
        $select->join('artist', 'artist.id = track.artist_id', array(
                      'artist' => 'name'
        ));
        $select->join('album', 'album.id = track.album_id', array(
                      'album' => 'name', 'artist_id', 'year'
        ));
        if (!is_null($artist)) {
            $select->where('artist.id = ?', $artist);
        }
        if (!is_null($query)) {
            $select->where("track.title LIKE '%$query%'");
            $select->orWhere("artist.name LIKE '%$query%'");
        }
        $select->order('artist', 'ASC');
        $select->order('album');
        $select->order('track', 'ASC');

        $adapter = new Zend_Paginator_Adapter_DbTableSelect($select);

        return $adapter;
    }

    public function fetchAlbum($album_id) {
        $select = $this->_getGateway()
                       ->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
                       ->setIntegrityCheck(FALSE);
        $select->join('artist', 'artist.id = track.artist_id', array(
            'artist' => 'name'
        ));
        $select->join('album', 'album.id = track.album_id', array(
            'album' => 'name', 'artist_id', 'year', 'art'
        ));
        $select->where('album_id = ?', $album_id);
        $select->order('track', 'ASC');

        $result = $this->_getGateway()->fetchAll($select);

        return $result;
    }

    /**
     * Delete a single row in database table.
     *
     * @param Application_Model_Track $track
     */
    public function delete($track) {

        if ($track instanceof Application_Model_Track) {
            $where = $this->_getGateway()->getAdpater()
                    ->quoteInto('id = ?', $track->id);
        } else {
            $where = $this->_getGateway()->getAdapter()
                    ->quoteInto('id = ?', $track);
        }
        $this->_getGateway()->delete($where);
    }
    protected function createEntity($row) {

    }

}
