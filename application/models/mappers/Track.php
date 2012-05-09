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
}
