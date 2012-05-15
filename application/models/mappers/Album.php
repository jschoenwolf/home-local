<?php

/**
 * Description of Application_Model_Mapper_Album
 *
 * @author John Schoenwolf
 */
class Application_Model_Mapper_Album extends Jgs_Application_Model_Mapper
{

    /**
     * Name of database table as a string
     *
     * @var string $_tablename
     */
    protected $_tableName = 'album';
    /**
     * Name of entity model class as a string.
     *
     * @var string $_entityClass
     */
    protected $_entityClass = 'Application_Model_Album';

    /**
     * Find a single row in the database table.
     *
     * @param type string $id
     * @return Application_Model_Album
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
            $album = new $this->_entityClass(array(
                        'id'   => $row->id,
                        'name' => $row->name,
                        'art'  => $row->art,
                        'year' => $row->year
                    ));
            $album->setReferenceId('artist', $row->artist_id);
            $this->_setIdentity($id, $album);

            return $album;
        }
    }


    /**
     * Insert or update a single row in database table.
     *
     * @param Application_Model_Album $album
     */
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

    /**
     * Delete a single row in database table.
     *
     * @param Application_Model_Album $album
     */
    public function delete($album) {

        if ($album instanceof Application_Model_Album) {
            $where = $this->_getGateway()->getAdapter()
                          ->quoteInto('id = ?', $album->id);
        } else {
            $where = $this->_getGateway()->getAdapter()
                          ->quoteInto('id = ?', $album);
        }
        $this->_getGateway()->delete($where);
    }
    protected function createEntity($row) {

    }

}
