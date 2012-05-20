<?php

/**
 * Description of Jgs_Application_Model_Entity_Abstract
 *
 * @author John Schoenwolf
 */
abstract class Jgs_Application_Model_Entity_Abstract
{

    protected $_data = array();


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
        $this->_data[$name] = $value;
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
                    $this, $accessor))) ? $this->$accessor() : $this->property;
    }

    /**
     * Get the entity fields.
     */
    public function toArray() {
        return $this->_data;
    }
}
