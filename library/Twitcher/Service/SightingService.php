<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Twitcher\Service;

use Bisna\Service\AbstractService;
use Twitcher\Entity;

class SightingService extends AbstractService
{

    const API_ADD_BIRD_KEY = 'id';



    const ERR_BIRD_INVALID = 61;
    const ERR_BIRD_INVALID_MSG = 'Invalid Bird provided';

    const ERR_SIGHTING_INVALID = 62;
    const ERR_SIGHTING_INVALID_MSG = 'Invalid Sighting provided';

    const ERR_USER_NOT_AUTH = 63;
    const ERR_USER_NOT_AUTH_MSG = 'User not authorised to edit Sighting';



    const QUOT_KM = 110.6;
    const QUOT_MI = 68.703;

   protected $repoUser;

   protected $repoSighting;

   protected $repoBird;

   public function setupRepos()
   {
       if(!$this->repoUser) $this->repoUSer =  $this->getEntityManager()->getRepository('\Twitcher\Entity\User');

       if(!$this->repoSighting)$this->repoSighting =  $this->getEntityManager()->getRepository('\Twitcher\Entity\Sighting');

       if(!$this->repoBird) $this->repoBird = $this->getEntityManager()->getRepository('\Twitcher\Entity\Bird');
   }




   public function addSighting($user, $data)
   {
       $this->setupRepos();

       //key to search for the bird Entity on
       $birdKey = self::API_ADD_BIRD_KEY;

       //find bird given in data, if not found, exception thrown
       $bird = $this->repoBird->findOneBy(array($birdKey=>$data['bird']));

       if(!$bird)
          throw new \Zend_Exception(self::ERR_BIRD_INVALID_MSG,self::ERR_BIRD_INVALID,null);

       //check the iphone_sighting_id given
       $data['device_sighting_id'] = $data['sighting_id'];


       //user and bird Entites added to data
       $data['user'] = $user;
       $data['bird'] = $bird;

       //create new object, save and flush, throw exception if error
       $newSighting = new Entity\Sighting();

       $addCount = 0;
       try
       {       
            $this->repoSighting->saveSighting($newSighting,$data);
     
            $this->getEntityManager()->flush();
            $addCount++;
       }
       catch (Zend_Exception $e)
       {
           $e->code = '62';
           $e->message = 'Error saving sighting';
       }

       return $addCount;

   }


   public function listSighting($terms)
   {
       $this->setupRepos();

       return $this->repoSighting->getWhere($terms);
   }

   public function listRecentSightings($terms,$offset = 0, $limit =15)
   {
       $this->setupRepos();
       $orderBy = "Sighting.timestamp";
       $orderDirection = 'DESC';

       return $this->repoSighting->getWhere($terms,$orderBy, $orderDirection, $offset, $limit);
   }

   public function editSighting($user, $sightingData)
   {
       $this->setupRepos();

       $sighting = $this->getSightingByDeviceId($sightingData['sighting_id']);
       
       if(!$sighting)
           throw new \Zend_Exception(self::ERR_SIGHTING_INVALID_MSG, self::ERR_SIGHTING_INVALID);

       if($this->userAuthSightingEdit($user, $sighting) == false)
            throw new \Zend_Exception(self::ERR_USER_NOT_AUTH, self::ERR_USER_NOT_AUTH_MSG);

        unset($sightingData['sighting_id']);

        $this->repoSighting->saveSighting($sighting, $sightingData);
            

   }
   
    public function getSightingByDeviceId($deviceSID)
    {
        $this->setupRepos();
        return $this->repoSighting->findOneBy(array('device_sighting_id'=>$deviceSID));
    }


    public function userAuthSightingEdit($user,$sighting)
    {
        return $user->getId() == $sighting->getUser->getId();

    }


    public function getBird($id)
    {

        $this->setupRepos();
        return $this->repoBird->find($id);
    }



    
}
