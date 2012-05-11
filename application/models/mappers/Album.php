<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Album
 *
 * @author john
 */
class Application_Model_Mapper_Album extends JGS_Model_Mapper
{
    protected $_tableName = 'album';
    protected $_entityClass = 'Application_Model_Album';

    public function find($id) {
        if ($this->_getIdentity($id)) {
            return $this->_getIdentity($id);
        }
        $result = $this->_getGateway()->find($id)->current();
        $album = new $this->_entityClass(array(
                    'id'   => $result->id,
                    'name' => $result->name,
                    'art'  => $result->art,
                    'year' => $result->year
                ));
        $album->setReferenceId('artist', $result->artist_id);
        $this->_setIdentity($id, $album);
        Zend_Debug::dump($album, 'AlbumMapper');
        return $album;
    }

    public function save(Application_Model_Album $album) {

        if (!$album->id) {
            $data = array(
                'name'      => $album->name,
                'art'       => $album->art,
                'year'      => $album->year,
                'artist_id' => $album->artist->id
            );
            $album->id = $this->_getGateway()->insert($data);
            $this->_setIdentity($album->id, $album);
        } else {
            $data = array(
                'id'        => $album->id,
                'name'      => $album->name,
                'art'       => $album->art,
                'year'      => $album->year,
                'artist_id' => $album->artist->id
            );
            $where = $this->_getGateway()->getAdapter()
                    ->quoteInto('id = ?', $album->id);
            $this->_getGateway()->update($data, $where);
        }
    }
}
