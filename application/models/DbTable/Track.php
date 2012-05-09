<?php

class Application_Model_DbTable_Track extends Zend_Db_Table_Abstract
{
    protected $_name = 'track';
//    protected $_primary = 'id';
    protected $_referenceMap = array(
        'Artist' => array(
            'columns'       => 'artist_id',
            'refTableClass' => 'Application_Model_DbTable_Artist',
            'refColumns'    => 'id'
        ),
        'Album' => array(
            'columns'       => 'album_id',
            'refTableClass' => 'Application_Model_DbTable_Album',
            'refColumns'    => 'id'
            ));

    /**
     * Fetch a single Row object by column, value
     *
     * @param string $fieldName
     * @param string $fieldValue
     * @return object/boolean
     */
    public function fetchTrackRow($fieldName = NULL, $fieldValue = NULL) {

        $select = $this->select();
        $select->where("$fieldName = ?", $fieldValue);

        $result = $this->fetchRow($select);
        if ($result) {
            return $result;
        } else {
            return FALSE;
        }
    }

    /**
     * Save/update Row
     *
     * @param array $data
     * @return object
     */
    public function saveTrack(array $data) {
        //cast array as object for convience.
        $dataObject = (object) $data;
        //if data contains 'id' key and 'id' isset, find row, else create new row.
        if (array_key_exists('id', $data) && isset($data['id'])) {
            $row = $this->find($dataObject->id)->current();
        } else {
            $row = $this->createRow();
        }
        $row->title     = $dataObject->title;
        $row->filename  = $dataObject->filename;
        $row->format    = $dataObject->format;
        $row->artist_id = $dataObject->artist_id;
        $row->genre     = $dataObject->genre;
        $row->album_id  = $dataObject->album_id;
        $row->track     = $dataObject->track;
        $row->play_time = $dataObject->play_time;
        $row->path      = $dataObject->path;
        $row->hash      = $dataObject->hash;
        //Save new row or update existing row.
        $row->save();
        //Return row object.
        return $row;
    }

    /**
     * Fetch all tracks (paginated),
     * ordered by artist.name, album.name and track #
     *
     * @return \Zend_Paginator_Adapter_DbTableSelect
     */
    public function fetchPagedTracks() {

        $select = $this->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
                ->setIntegrityCheck(FALSE);
        $select->join(array('ar' => 'artist'), 'ar.id = track.artist_id',
                array('artist' => 'name'));
        $select->join(array('al' => 'album'), 'al.id = track.album_id',
                array('album' => 'name', 'artist_id', 'year'));
        $select->order('artist', 'ASC');
        $select->order('album');
        $select->order('track', 'ASC');

        //create a new instance of the paginator adapter and return it
        $adapter = new Zend_Paginator_Adapter_DbTableSelect($select);

        return $adapter;
    }

    /**
     * Fetch all tracks with all data, not paginated.
     *
     * @return object
     */
    public function fetchAllTrackData() {

        $select = $this->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
                ->setIntegrityCheck(FALSE);
        $select->join(array('ar' => 'artist'), 'ar.id = track.artist_id',
                array('artist_name' => 'name', 'artist_id' => 'id'));
        $select->join(array('al' => 'album'), 'al.id = track.album_id',
                array('album_name' => 'name', 'albumArtist_id' => 'artist_id',
            'year'));
        $result = $this->fetchAll($select);

        return $result;
    }

    /**
     * Fetch tracks (paginated), by artist_id
     * ordered by artist.name, album.name and track #
     *
     * @param string $id
     * @return \Zend_Paginator_Adapter_DbTableSelect
     */
    public function fetchAllByArtistPaged($id) {

        $select = $this->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
                ->setIntegrityCheck(FALSE);
        $select->join(array('ar' => 'artist'), 'ar.id = track.artist_id',
                array('artist' => 'name'));
        $select->join(array('al' => 'album'), 'al.id = track.album_id',
                array('album' => 'name', 'artist_id', 'year'));
        $select->where('ar.id = ?', $id);
        $select->order('artist', 'ASC');
        $select->order('album');
        $select->order('track', 'ASC');

        $adapter = new Zend_Paginator_Adapter_DbTableSelect($select);

        return $adapter;
    }

    /**
     * Fetch tracks (paginated), by query against title and artist name,
     * ordered by artist.name, album.name and track #
     *
     * @param string $query
     * @return \Zend_Paginator_Adapter_DbTableSelect
     */
    public function fetchAllByQueryPaged($query) {

        $select = $this->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
                ->setIntegrityCheck(FALSE);
        $select->join(array('ar' => 'artist'), 'ar.id = track.artist_id',
                array('artist' => 'name'));
        $select->join(array('al' => 'album'), 'al.id = track.album_id',
                array('album' => 'name', 'artist_id', 'year'));
        $select->where("track.title LIKE '%$query%'");
        $select->orWhere("ar.name LIKE '%$query%'");
        $select->order('artist', 'ASC');
        $select->order('album');
        $select->order('track', 'ASC');

        $adapter = new Zend_Paginator_Adapter_DbTableSelect($select);

        return $adapter;
    }
}

