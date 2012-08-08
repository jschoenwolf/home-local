<?php

/**
 * Description of Jgs_Model_Entity_Abstract
 *
 * Abstract class describing basic methods for domain objects.
 *
 * @author John Schoenwolf
 */
abstract class Jgs_Model_Entity_Abstract
{
    /**
     * An array of id's of reference entities
     *
     * @var array
     */
    protected $_references = array();
    /**
     * Id of entity
     *
     * @var string
     */
    protected $_id;

    /**
     * accepts an array of data for instantiating entity objects
     *
     * @param array $options
     */
    public function __construct(array $options = NULL) {

        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    /**
     *
     * @param array $options
     * @return \Jgs_Application_Model_Entity_Abstract
     */
    public function setOptions(array $options) {

        $methods = get_class_methods($this);

        foreach ($options as $key => $value) {

            $method = 'set' . ucfirst($key);
            if (in_array($method, $methods)) {
                $this->$method($value);
            }
        }
        return $this;
    }

    /**
     * Map the setting of non-existing fields to a mutator when
     * possible, otherwise use the matching field
     */
    public function __set($name, $value) {

        $property = '_' . strtolower($name);

        if (!property_exists($this, $property)) {
            throw new \InvalidArgumentException("Setting the property '$property'
                    is not valid for this entity");
        }
        $mutator = 'set' . ucfirst(strtolower($name));

        if (method_exists($this, $mutator) && is_callable(array($this, $mutator))) {
            $this->$mutator($value);
        } else {
            $this->$property = $value;
        }


        return $this;
    }

    /**
     * Map the getting of non-existing properties to an accessor when
     * possible, otherwise use the matching field
     */
    public function __get($name) {

        $property = '_' . strtolower($name);

        if (!property_exists($this, $property)) {
            throw new \InvalidArgumentException(
                    "Getting the property '$property' is not valid for this entity");
        }
        $accessor = 'get' . ucfirst(strtolower($name));
        return (method_exists($this, $accessor) && is_callable(array(
                    $this, $accessor))) ? $this->$accessor() : $this->$property;
    }

    /**
     * implements toArray()
     *
     * @return array
     */
    public function toArray() {
        $vars = get_object_vars($this);
        $array = array();
        foreach ($vars as $key => $value) {
            if ((stripos($key, 'mapper') || stripos($key, 'references')) === FALSE) {
                if (is_null($value)) {
                    $array[ltrim($key, '_')] = $this->getReferenceId(ltrim($key, '_'));
                } else {
                    $array[ltrim($key, '_')] = $value;
                }
            }
        }
        return $array;
    }

    /**
     * Set entity Id
     *
     * @param type $id
     * @return \Jgs_Model_Entity_Abstract
     */
    public function setId($id) {
        $this->_id = $id;
        return $this;
    }

    /**
     * get Entity Id
     *
     * @return string
     */
    public function getId() {
        return $this->_id;
    }

    /**
     * sets reference data for lazy loading of associated objects
     *
     * @param string $name
     * @param string $id
     */
    public function setReferenceId($name, $id) {

        $this->_references[$name] = $id;
    }

    /**
     * retrieve reference data to lazy load object
     *
     * @param string $name
     * @return string
     */
    public function getReferenceId($name) {

        if (isset($this->_references[$name])) {

            return $this->_references[$name];
        }
    }
}
