<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Acl
 *
 * @author john
 */
class Jgs_Controller_Plugin_Acl extends Zend_Controller_Plugin_Abstract
{

    public function preDispatch(Zend_Controller_Request_Abstract $request) {
        parent::preDispatch($request);
        //setup ACL
        $acl = new Zend_Acl();
        //add Roles
        $acl->addRole('guest');
        $acl->addRole('user', 'guest');
        $acl->addRole('administrator', 'user');

        //add Resources
        $acl->add(new Zend_Acl_Resource('index'));
        $acl->add(new Zend_Acl_Resource('error'));
        $acl->add(new Zend_Acl_Resource('page'));
        $acl->add(new Zend_Acl_Resource('menu'));
        $acl->add(new Zend_Acl_Resource('menuitem'));
        $acl->add(new Zend_Acl_Resource('user'));
        $acl->add(new Zend_Acl_Resource('search'));
        $acl->add(new Zend_Acl_Resource('feed'));
        $acl->add(new Zend_Acl_Resource('contact'));
        $acl->add(new Zend_Acl_Resource('bug'));

        //set up access rules
        $acl->allow(NULL, array('index', 'error'));
        $acl->allow(NULL, array('index', 'index'));

        //a guest can only read content and login
        $acl->allow('guest', 'page', array('index', 'open'));
        $acl->allow('guest', 'menu', array('render'));
        $acl->allow('guest', 'user', array('login', 'logout'));
        $acl->allow('guest', 'search', array('index', 'search'));
        $acl->allow('guest', 'feed');
        $acl->allow('guest', 'contact', array('contact', 'index', 'index'));
        $acl->allow('guest', 'bug');

        //users can also work with content
        $acl->allow('user', 'page', array('list', 'create', 'edit', 'delete'));

        //administrators can do anything
        $acl->allow('administrator', NULL);

        //fetch current user
        $auth = Zend_Auth::getInstance();
        if ($auth->hasIdentity()) {
            $identity = $auth->getIdentity();
            $role = strtolower($identity->role);
        } else {
            $role = 'guest';
        }

        $controller = $request->controller;
        $action = $request->action;

        if (!$acl->isAllowed($role, $controller, $action)) {
            if ($role == 'guest') {
                $request->setControllerName('user');
                $request->setActionName('login');
            } else {
                $request->setControllerName('error');
                $request->setActionName('noauth');
            }
        }
    }
}
