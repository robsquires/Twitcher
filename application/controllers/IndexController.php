<?php

class IndexController extends Zend_Controller_Action
{

    protected $serviceUser = null;

    protected $serviceSighting = null;

    public function init()
    {
        //Initialise Service Layer
                                $container = $this->getInvokeArg('bootstrap')->getResource('doctrine');
                                $serviceLocator = $this->getInvokeArg('bootstrap')->getResource('serviceLocator');
                        
                                //initialise services
                                $this->serviceSighting = $serviceLocator->getService('sighting');
                                $this->serviceUser = $serviceLocator->getService('user');
    }

    public function indexAction()
    {
        // action body
                        
                        
                        
                                //get recent sightings - aka
                        
                                $query = array();
                                
                                $sightings = array();
                                
                                foreach ($this->serviceSighting->listRecentSightings($query, 0 ,10) as $sighting)
                                {
                                    $sightings[] = array('sighting'=>$sighting);
                                }
                        
                                $this->view->sightings = $sightings;
    }

    public function signUpAction()
    {
        $signupForm = new Zend_Form();
        $signupForm->setMethod('post');
        $signupForm->addElement('text',
                                'username',
                                array('label'=>'Username:','required'=>'true')
                    );
        
        $signupForm->addElement('text',
                                'email',
                                array('label'=>'Email Address:','required'=>'true')
                    );

        $signupForm->addElement('password',
                                'password',
                                array('label'=>'Password:','required'=>'true')
                    );

        $signupForm->addElement('password',
                                'password_confimation',
                                array('label'=>'Password Confirmation:','required'=>'true')
                    );
        $signupForm->addElement('submit',
                                'Submit'
                    );


        if($this->getRequest()->isPost() && $signupForm->isValid($this->getRequest()->getParams()))
        {
            
            $this->serviceUser->createUser($signupForm->getValues());
        }



        $this->view->form = $signupForm;


    }

    public function loginAction()
    {
        // action body
    }

    public function logoutAction()
    {
        // action body
    }


}







