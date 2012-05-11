<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TrackMapper
 *
 * @author john
 */
class Application_Model_Mapper_Track extends JGS_Model_Mapper
{
    protected $_tableName = 'track';
    protected $_entityClass = 'Application_Model_Track';

    /**
     *
     * @param type $id
     * @return Application_Model_Track
     */
    public function find($id) {
        if ($this->_getIdentity($id)) {
            return $this->_getIdentity($id);
        }
        $result = $this->_getGateway()->find($id)->current();
        $track = new $this->_entityClass(array(
                    'id'        => $result->id,
                    'title'     => $result->title,
                    'filename'  => $result->filename,
                    'path'      => $result->path,
                    'format'    => $result->format,
                    'genre'     => $result->genre,
                    'track'     => $result->track,
                    'hash'      => $result->hash,
                    'play_time' => $result->play_time
                ));
        $track->setReferenceId('artist', $result->artist_id);
        $track->setReferenceId('album', $result->album_id);
        $this->_setIdentity($id, $track);

        return $track;
    }

    /**
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

    /**
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
}
