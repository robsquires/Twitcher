<?php

class TestsController extends Zend_Controller_Action
{


    protected $user;
    protected $bird;

    public function init()
    {
        //Initialise Service Layer
        $container = $this->getInvokeArg('bootstrap')->getResource('doctrine');
        $serviceLocator = $this->getInvokeArg('bootstrap')->getResource('serviceLocator');

        //initialise services
        $this->serviceSighting = $serviceLocator->getService('sighting');
        $this->serviceUser = $serviceLocator->getService('user');
        /* Initialize action controller here */

        
    }

    public function indexAction()
    {
        // action body
        //$userId = $this->getRequest()->getParam('user');
        $userId = 1;

        if(!$userId)
                throw new \Zend_Exception('user not provided',00);

        $user = $this->serviceUser->getUser($userId);

//        $birdId = $this->getRequest()->getParam('bird');
//        if(!$birdId)
//                throw new \Zend_Exception('bird not provided',00);

        $birdId = rand(1,300);
        $bird = $this->serviceSighting->getBird($birdId);

        $sightingForm = new Zend_Form();
        $sightingForm->setAction('/api/add-sighting');
        $sightingForm->getMethod('post');
        $sightingForm->addElement('hidden','bird', array('value'=>$bird->getId()));

        $sightingForm->addElement('hidden','longitude');
        $sightingForm->addElement('hidden','latitude');
        $sightingForm->addElement('hidden','grid_ref',array('value'=>'RX 124'));

        $sightingForm->addElement('hidden','request_time_stamp',array('value'=> date('U', time()) ));
        $sightingForm->addElement('hidden','time_stamp',array('value'=> date('U', time()) ));
        $sightingForm->addElement('hidden','user_key',array('value'=> $user->getUserKey()));

        $sightingForm->addElement('hidden','sighting_id',array('value'=> md5( date('U', time()) )));

        $sightingForm->addElement('submit','Submit');



        $this->view->bird = $bird->getFirstname() . " " . $bird->getLastname();
        $this->view->user = $user->getUsername();
        $this->view->form = $sightingForm;
    }


}

