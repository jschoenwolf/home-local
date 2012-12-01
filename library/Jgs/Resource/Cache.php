<?php

/**
 * Description of Jgs_Application_Resource_Cache
 *
 * @author john
 */
class Jgs_Application_Resource_Cache extends Zend_Application_Resource_ResourceAbstract
{
    /**
     *
     * @return object Zend_Cache
     */
    public function init()
    {
        $options = $this->getOptions();
        //get a zend_cache_core object()
        $cache   = Zend_Cache::factory(
                $options['frontend'], $options['backend'], $options['frontEndOptions'], $options['backEndOptions']
        );
        Zend_Registry::set('cache', $cache);
        return $cache;
    }

}
