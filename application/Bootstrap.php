<?php

/**
 * Application bootstrap file.
 */
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

    /**
     * initialize the session
     */
    protected function _initsession() {
        //start session
        Zend_Session::start();
    }

    /**
     * initialize the registry and asign application.ini to config namespace
     */
    protected function _initRegistry() {

        //make application.ini configuration available in registry
        $config = new Zend_Config($this->getOptions());
        Zend_Registry::set('config', $config);
    }

    /**
     * initialize the view and return it
     * @return \Zend_View
     */
    protected function _initView() {
        //Initialize view
        $view = new Zend_View();
        //add custom view helper path
        $view->addHelperPath('/../library/Jgs/Application/View/Helper');
        //set doctype for default layout
        $view->doctype(Zend_Registry::get('config')->resources->view->doctype);
        //set default title
        $view->headTitle('Our Home');
        //set head meta data
        $view->headMeta()->appendHttpEquiv('Content-Type', Zend_Registry::get(
                        'config')->resources->view->contentType);
        //set css includes
        $view->headLink()->setStylesheet('/css/normalize.css');
        $view->headLink()->appendStylesheet('/css/blueprint/src/liquid.css');
        $view->headLink()->appendStylesheet('/css/blueprint/src/typography.css');
        $view->headLink()->appendStylesheet(
                '/javascript/mediaelement/build/mediaelementplayer.css');
        $view->headLink()->appendStylesheet('/css/main.css');
        $view->headLink()->appendStylesheet('/css/nav.css');
        $view->headLink()->appendStylesheet('/css/table.css');
        //add javascript files
        $view->headScript()->setFile('/javascript/mediaelement/build/jquery.js');

        //add it to the view renderer
        $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper(
                        'ViewRenderer');
        $viewRenderer->setView($view);
        //Return it, so that it can be stored by the bootstrap
        return $view;
    }

    protected function _initHelpers() {

        Zend_Controller_Action_HelperBroker::addPath(
                '/../library/Jgs/Application/Controller/Action/Helper',
                'Jgs_Application_Controller_Action_Helper');
    }
}

