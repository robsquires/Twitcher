<?php

use Twitcher\Exception;
use Twitcher\Service\SightingService;
use Twitcher\Service\UserService;
use Bisna\Service;

class ApiController extends Zend_Controller_Action
{

    protected $serviceUser = null;
    protected $serviceSighting = null;
    protected $responseFormat = null;
    protected $user = null;
    protected $apiStartTimestamp = null;

    const FORMAT_ATOM = 'atom';
    const FORMAT_RSS = 'rss';
    const FORMAT_JSON = 'json';
    const FORMAT_XML = 'xml';
    const FORMAT_FORM = 'form';
    const FORMAT_HTML = 'html';

    const REQUEST_GET = 'get';
    const REQUEST_POST = 'post';

    //Status codes
    const RESP_ERR_INVALID_REQ_TYPE = 50;


    const RESP_ERR_INVALID_REQ_FORMAT = 51;
    const RESP_ERR_NO_USER_KEY = 52;
    const RESP_ERR_USER_NOT_FOUND = 53;
    const RESP_ERR_PARAMS_MISSING = 54;
    const RESP_ERR_PARAM_FORMAT = 55;
    const RESP_ERR_NOT_AUTH = 56;

    const RESP_OK = 20;



    /**
     * collection of response formats and their allowed request formats
     * @var array
     * 
     * 
     * 
     */
    protected $availableRequestFormats = array();
    protected $requestType = array();
    protected $reqData = null;

    public function init()
    {
        //Initialise Service Layer
        $container = $this->getInvokeArg('bootstrap')->getResource('doctrine');
        $serviceLocator = $this->getInvokeArg('bootstrap')->getResource('serviceLocator');

        //initialise services
        $this->serviceSighting = $serviceLocator->getService('sighting');
        $this->serviceUser = $serviceLocator->getService('user');

        //set HTTP request types for each action
        $this->requestType['add-sighting'] = self::REQUEST_POST;
        $this->requestType['edit-sighting'] = self::REQUEST_POST;
        $this->requestType['list'] = self::REQUEST_GET;

        //set request formats for a given response format for each ation
        $this->availableRequestFormats['add-sighting'] = array(
            self::FORMAT_JSON => self::FORMAT_JSON,
            self::FORMAT_XML => self::FORMAT_XML,
            self::FORMAT_HTML => self::FORMAT_FORM
        );

        $this->availableRequestFormats['edit-sighting'] = array(
            self::FORMAT_JSON => self::FORMAT_JSON,
            self::FORMAT_XML => self::FORMAT_XML,
            self::FORMAT_HTML => self::FORMAT_FORM
        );

        $this->availableRequestFormats['list'] = array(
            self::FORMAT_ATOM => self::FORMAT_FORM,
            self::FORMAT_RSS => self::FORMAT_FORM,
            self::FORMAT_JSON => self::FORMAT_FORM,
            self::FORMAT_XML => self::FORMAT_FORM,
            self::FORMAT_HTML => self::FORMAT_FORM
        );

        //setup context switching for each action
        $contextSwitch = $this->_helper->getHelper('contextSwitch');

        $contextSwitch->addActionContext('add-sighting', array(self::FORMAT_JSON, self::FORMAT_XML))
                ->initContext();

        $contextSwitch->addActionContext('edit-sighting', array(self::FORMAT_JSON, self::FORMAT_XML))
                ->initContext();

        $contextSwitch->addActionContext('list', array(self::FORMAT_JSON))
                ->initContext();

    }

    public function preDispatch()
    {
        //action called in this request
        $action = $this->getRequest()->getParam('action');

        //format specified in this request
        $format = $this->getRequest()->getParam('format');
        
        //if POST required for action, checking a POST has been made
        if ($this->requestType[$action] == self::REQUEST_POST && !$this->getRequest()->isPost())
            throw new \Zend_Exception('Please use POST for this action.', self::RESP_ERR_INVALID_REQ_TYPE);


        //determining the correct required request format given the response format provided
        //if format not specified, default to HTML
        //else use specific format for the response required
        if (!$format)
        {
            $this->requestFormat = $this->availableRequestFormats[$action][self::FORMAT_HTML];
            $this->responseFormat = self::FORMAT_HTML;
        }
        elseif (array_key_exists($format, $this->availableRequestFormats[$action]))
        {
            $this->requestFormat = $this->availableRequestFormats[$action][$format];
            $this->responseFormat = $format;
        }
        else
        {
            throw new Zend_Exception("Invalid Response Format.", self::RESP_ERR_INVALID_REQ_FORMAT, null);
        }

        //process data into a universal array
        $this->reqData = $this->processRequest($this->requestFormat);

        //reqData will be null if the request did not match its required format
        if (!$this->reqData)
            throw new Zend_Exception("Invalid Request Format. [$this->requestFormat] expected", self::RESP_ERR_INVALID_REQ_FORMAT, null);


        //if user_key not supplied will pass back error code
        if (!isset($this->reqData['user_key']))
            throw new Zend_Http_Exception('User Key not provided', self::RESP_ERR_NO_USER_KEY, null);


        //@todo - user not authorised
        $this->user = $this->serviceUser->apiAuthorise($this->reqData);

        if (!$this->user)
        {
            throw new Zend_Exception('Not Authorised', self::RESP_ERR_NOT_AUTH, null);
        }

        //@todo actual validation on the request_time_stamp
        $requestTime = $this->reqData['request_time_stamp'];

        if (!$requestTime)
        {
            throw New \Zend_Exception('Request Time not given', self::RESP_ERR_PARAMS_MISSING, null);
        }

    }

    private function processRequest($format)
    {
        switch ($format)
        {
            case self::FORMAT_JSON:

                try
                {
                    $reqData = Zend_Json_Decoder::decode(file_get_contents('php://input'));
                    break;
                } catch (Exception $e)
                {

                }

            case self::FORMAT_XML:
                try
                {
                    $reqData = simplexml_load_string(file_get_contents('php://input'));
                    break;
                } catch (Exception $e)
                {

                }
            case self::FORMAT_ATOM:
                $reqData = $this->getRequest()->getParams();
                break;

            case self::FORMAT_RSS:
                $reqData = $this->getRequest()->getParams();
                break;

            case self::FORMAT_FORM:
                $reqData = $this->getRequest()->getParams();
                break;
        }

        return $reqData;
    }


    public function indexAction()
    {
        // action body
    }

    public function addSightingAction()
    {
        $addSightingForm = new Zend_Form();

        $stringQS = new Zend_Validate_Alnum(true);
        //@todo - add date validation to addSighting
        $date = new Zend_Validate_Date(array("format" => Zend_Date::TIMESTAMP));

        $addSightingForm->addElement('text',
                'bird',
                array('required' => 'true',
                    'validators' => array('digits')));
        $addSightingForm->addElement('text',
                'longitude',
                array('required' => 'true',
                    'validators' => array('float')));
        $addSightingForm->addElement('text',
                'latitude',
                array('required' => 'true',
                    'validators' => array('float')));
        $addSightingForm->addElement('text',
                'grid_ref',
                array('required' => 'true',
                    'validators' => array($stringQS)));

        $addSightingForm->addElement('text',
                'sighting_id',
                array('required' => 'true',
                    'validators' => array('Alnum')));
        $addSightingForm->addElement('text',
                'time_stamp',
                array('required' => 'true'
        ));
        $addSightingForm->addElement('text',
                'notes',
                array());

        $addSightingForm->addElement('text',
                'address',
                array());

        if (!$addSightingForm->isValid($this->reqData))
        {
            throw new Zend_Exception('Parameter missing or invalid format', self::RESP_ERR_PARAM_FORMAT, null);
            $this->view->errors = $addSightingForm->getErrors();
        }

        $addCount = $this->serviceSighting->addSighting($this->user, $addSightingForm->getValues());


        $this->view->response = "OK";
        $this->view->code = self::RESP_OK;
        $this->view->message = "Sighting added OK.";
        $this->view->count = $addCount;
        //$this->view->timestamp = date('d-m-Y H:i:s');
    }

    public function deleteSightingAction()
    {
        // action body
    }

    public function viewSightingAction()
    {
        // action body
    }
    //@todo - delete errorAction
    public function errorAction()
    {
        $this->view->exception = $this->responseCode;
    }


    public function listAction()
    {
        // action body

        $listForm = new Zend_Form();

        $listForm->addElement('text',
                'bird',
                array('validators' => array('Alnum'))
        );

        $listForm->addElement('text',
                'latin',
                array('validators' => array('Alnum'))
        );

        $listForm->addElement('text',
                'user',
                array('validators' => array('Alnum'))
        );

        $listForm->addElement('text',
                'date_from',
                array('validators' => array('Int'))
        );
        $listForm->addElement('text',
                'date_to',
                array('validators' => array('Int'))
        );
        $listForm->addElement('text',
                'time_from',
                array('validators' => array('Int'))
        );
        $listForm->addElement('text',
                'time_to',
                array('validators' => array('Int'))
        );
        $listForm->addElement('text',
                'longitude',
                array('validators' => array('float'))
        );
        $listForm->addElement('text',
                'latitude',
                array('validators' => array('float'))
        );
        $listForm->addElement('text',
                'distance',
                array('validators' => array('Int'))
        );

        if (!$listForm->isValid($this->reqData))

            throw new \Zend_Exception('Parameters missing or Invalid format', self::RESP_ERR_PARAM_FORMAT, null);



        $data = array();

        foreach($this->serviceSighting->listSighting($listForm->getValues()) as $sighting)
        {
            $data[] = array(
               'bird'=> $sighting->getBird()->getId(),
               'longitude'=>$sighting->getLongitude(),
               'latitude'=>$sighting->getLatitude(),
               'grid_ref'=>$sighting->getGridRef(),
               'time_stamp'=> (integer) $sighting->getTimestamp()->format('U'),
               'sighting_id'=>$sighting->getDeviceSightingId()
           );
        }


        $this->view->reponse = 'OK';
        $this->view->code = self::RESP_OK;
        $this->view->sightings = $data;

    }

    public function editSightingAction()
    {
        $editSightingForm = new Zend_Form();

        $stringQS = new Zend_Validate_Alnum(true);
        //@todo - add date validation to editSighting
        $date = new Zend_Validate_Date(array("format" => Zend_Date::TIMESTAMP));

        $editSightingForm->addElement('text',
                'sighting_id',
                array('required' => 'true',
                    'validators' => array('Alnum')));

        $editSightingForm->addElement('text',
                'bird',
                array('required' => 'false',
                    'validators' => array('digits')));

        $editSightingForm->addElement('text',
                'longitude',
                array('required' => 'false',
                    'validators' => array('float')));
        $editSightingForm->addElement('text',
                'latitude',
                array('required' => 'false',
                    'validators' => array('float')));
        $editSightingForm->addElement('text',
                'grid_ref',
                array('required' => 'false',
                    'validators' => array($stringQS)));


        $editSightingForm->addElement('text',
                'time_stamp',
                array('required' => 'false'
        ));
        $editSightingForm->addElement('text',
                'notes',
                array('required' => 'false'));

        $editSightingForm->addElement('text',
                'address',
                array('required' => 'false'));


        if (!$editSightingForm->isValid($this->reqData))
        {
            throw new Zend_Exception('Parameter missing or invalid format', self::RESP_ERR_PARAM_FORMAT, null);
            $this->view->errors = $editSightingForm->getErrors();
        }

        $editResult = $this->serviceSighting->editSighting($this->user, $editSightingForm->getValues());


        $this->view->response = "OK";
        $this->view->code = self::RESP_OK;
        $this->view->message = "Sighting editted Ok.";
        $this->view->count = $addCount;
    }

}

