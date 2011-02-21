<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    public function _initAutoloaderNamespaces()
    {
        
        require_once APPLICATION_PATH . '/../library/Doctrine/Common/ClassLoader.php';

        $autoloader = \Zend_Loader_Autoloader::getInstance();
        $fmmAutoloader = new \Doctrine\Common\ClassLoader('Bisna');
        $autoloader->pushAutoloader(array($fmmAutoloader, 'loadClass'), 'Bisna');

                // Your Application autoloader goes here!
        $appAutoloader = new \Doctrine\Common\ClassLoader('Twitcher');
        $autoloader->pushAutoloader(array($appAutoloader, 'loadClass'), 'Twitcher');
        
    }




}

