<?php

/**
 * Description of Application_Model_Track
 *
 * @author John Schoenwolf
 */
class Application_Model_Track extends Jgs_Model_Entity
{
    /**
     * An array of object entities.
     *
     * @var array $_data
     */
    protected $_data = array(
        'id'        => NULL,
        'title'     => '',
        'filename'  => '',
        'path'      => '',
        'format'    => '',
        'genre'     => '',
        'track'     => '',
        'hash'      => '',
        'play_time' => '',
        'artist'    => NULL,
        'album'     => NULL
    );
    /**
     * An array of reference id's for lazy loading related objects.
     *
     * @var array $_references
     */
//    protected $_references = array();
    /**
     * Name of related objects mapper class a string.
     *
     * @var string $_albumMapperClass
     */
    protected $_albumMapperClass = 'Application_Model_Mapper_Album';
    /**
     * InstanceOf related object mapper, lazy loaded.
     *
     * @var Application_Model_Mapper_Album $_albumMapper
     */
    protected $_albumMapper = NULL;
    /**
     * Name of related objects mapper class a string.
     *
     * @var string $_artistMapperClass
     */
    protected $_artistMapperClass = 'Application_Model_Mapper_Artist';
    /**
     * InstanceOf related object mapper, lazy loaded.
     *
     * @var Application_Model_Mapper_Artist $_artistMapper
     */
    protected $_artistMapper = NULL;

    /**
     * Magic Method setter for values of $_data, Overrides parent __set().
     *
     * @param string $name
     * @param string $value
     * @throws Zend_Db_Table_Exception
     */
    public function __set($name, $value) {
        //If array key = album and value is not instance of entity model, throw exception.
        if ($name == 'album' && !$value instanceof Application_Model_Album) {
            throw new Zend_Db_Table_Exception(
                    "'Album' can only be set using an instance of 'Application_Model_Album'."
            );
        }
        //If array key = artist and value is not instance of entity model, throw exception.
        if ($name == 'artist' && !$value instanceof Application_Model_Artist) {
            throw new Zend_Db_Table_Exception(
                    "'Artist' can only be set using an instance of 'Application_Model_Artist'."
            );
        }
        parent::__set($name, $value);
    }

    /**
     * Magic Method getter for values of $_data, Overrides parent __get().
     *
     * @param string $name
     * @return string
     */
    public function __get($name) {
        //Fetch instanceOf Application_Model_Album as required.
        if ($name == 'album' && $this->getReferenceId('album') &&
                !$this->_data['artist'] instanceof Application_Model_Album) {
            if (!$this->_albumMapper) {
                $this->_albumMapper = new $this->_albumMapperClass();
            }
            $this->_data['album'] = $this->_albumMapper->find($this->getReferenceId('album'));
        }
        //Fetch instanceOf Application_Model_Artist as required.
        if ($name == 'artist' && $this->getReferenceId('artist') &&
                !$this->_data['artist'] instanceof Application_Model_Artist) {
            if (!$this->_artistMapper) {
                $this->_artistMapper = new $this->_artistMapperClass();
            }
            $this->_data['artist'] = $this->_artistMapper->find($this->getReferenceId('artist'));
        }
        return parent::__get($name);
    }

    /**
     *
     * @param Application_Model_Mapper_Album $mapper
     */
    public function setAlbumMapper(Application_Model_Mapper_Album $mapper) {

        $this->_albumMapper = $mapper;
    }

    /**
     *
     * @param Application_Model_Mapper_Artist $mapper
     */
    public function setArtistMapper(Application_Model_Mapper_Artist $mapper) {

        $this->_artistMapper = $mapper;
    }
}
