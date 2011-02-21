<?php

use Twitcher\Exception;

class ErrorController extends Zend_Controller_Action
{


    const FORMAT_ATOM = 'atom';
    const FORMAT_RSS = 'rss';
    const FORMAT_JSON = 'json';
    const FORMAT_XML = 'xml';
    const FORMAT_GET = 'get';

    public function init()
    {

        $contextSwitch = $this->_helper->getHelper('contextSwitch');
        $contextSwitch->addActionContext('error', array(self::FORMAT_JSON, self::FORMAT_XML))
                ->initContext();


        
    }

    public function errorAction()
    {
        $errors = $this->_getParam('error_handler');


        if (!$errors) {
            $this->view->message = 'You have reached the error page';
            return;
        }


        //simple error handling - only want a message and a code

        $this->view->response = 'error';
        $this->view->message = $errors->exception->getMessage();
        $this->view->code = $errors->exception->getCode();



         if ($this->getInvokeArg('displayExceptions') == true) {
            $this->view->exception = $errors->exception;
            $this->view->request   = $errors->request;
        }

    }











    public function errorARCH()
    {


        $errors = $this->_getParam('error_handler');
        
        if (!$errors) {
            $this->view->message = 'You have reached the error page';
            return;
        }
        
        switch ($errors->type) {
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ROUTE:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
            case Exception\ErrorHandler::RESP_ERR_INVALID_REQ_FORMAT:

                $this->view->message = 'Invalid Request Format.';
                
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:
        
                // 404 error -- controller or action not found
                $this->getResponse()->setHttpResponseCode(404);
                $this->view->message = 'Page not found';
                break;
            default:
                // application error
                $this->getResponse()->setHttpResponseCode(500);
                $this->view->message = 'Application error';
                break;
        }
        
        // Log exception, if logger available
        if ($log = $this->getLog()) {
            $log->crit($this->view->message, $errors->exception);
        }
        
        // conditionally display exceptions
        if ($this->getInvokeArg('displayExceptions') == true) {
            $this->view->exception = $errors->exception;
        }
        
        $this->view->request   = $errors->request;
    }

    public function getLog()
    {
        $bootstrap = $this->getInvokeArg('bootstrap');
        if (!$bootstrap->hasResource('Log')) {
            return false;
        }
        $log = $bootstrap->getResource('Log');
        return $log;
    }


}

