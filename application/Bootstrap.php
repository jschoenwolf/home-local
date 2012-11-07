<?php

/**
 * Application bootstrap file.
 */
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    /**
     * initialize the session
     */
    protected function _initsession()
    {
        Zend_Session::start();
    }

    /**
     * initialize the registry and asign application.ini to config namespace
     */
    protected function _initRegistry()
    {
        $config = new Zend_Config($this->getOptions());
        Zend_Registry::set('config', $config);
    }

    /**
     * initialize the view and return it
     * @return \Zend_View
     */
    protected function _initView()
    {
        //Initialize view
        $view = new Zend_View();
        //add custom view helper path
        $view->addHelperPath('/../library/Jgs/View/Helper');
        //set doctype for default layout
        $view->doctype(Zend_Registry::get('config')->resources->view->doctype);
        //set default title
        $view->headTitle('Our Home');
        //set head meta data
        $view->headMeta()->appendHttpEquiv('Content-Type', Zend_Registry::get(
                'config')->resources->view->contentType);
        //set css includes
        $view->headlink()->setStylesheet('/bootstrap/css/bootstrap.min.css');
        $view->headLink()->appendStylesheet('/css/main.css');
        $view->headLink()->appendStylesheet('/css/nav.css');
        $view->headLink()->appendStylesheet('/css/table.css');
        //add javascript files
        $view->headScript()->setFile('/bootstrap/js/jquery.min.js');
        $view->headScript()->appendFile('/bootstrap/js/bootstrap.min.js');
        //add it to the view renderer
        $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper(
                'ViewRenderer');
        $viewRenderer->setView($view);
        //Return it, so that it can be stored by the bootstrap
        return $view;
    }

}
