<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Cache
 *
 * @author john
 */
class JGS_Application_Resource_Cache extends Zend_Application_Resource_ResourceAbstract
{

    public function init() {
        $options = $this->getOptions();
        //get a zend_cache_core object()
        $cache = Zend_Cache::factory(
                        $options['frontend'], $options['backend'],
                        $options['frontEndOptions'], $options['backEndOptions']
        );
        Zend_Registry::set('cache', $cache);
        return $cache;
    }
}
