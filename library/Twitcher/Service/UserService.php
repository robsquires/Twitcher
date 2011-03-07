<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Twitcher\Service;

use Bisna\Service\AbstractService;
use Twitcher\Entity;
use Twitcher\Entity\User;

class UserService extends AbstractService
{

   protected $repoUser;

   protected $repoSighting;

   protected $repoBird;

   protected $repoMaster;

   public function setupRepos()
   {
       if(!$this->repoUser) $this->repoUser =  $this->getEntityManager()->getRepository('\Twitcher\Entity\User');

       if(!$this->repoSighting) $this->repoSighting = $this->getEntityManager()->getRepository('\Twitcher\Entity\Sighting');

       if(!$this->repoBird) $this->repoBird = $this->getEntityManager ()->getRepository ('\Twitcher\Entity\Bird');

       if(!$this->repoMaster) $this->repoMaster = $this->getEntityManager ()->getRepository ('\Twitcher\Entity\MasterData');


   }


   public function apiAuthorise($data)
   {return true;
      $this->setupRepos();
      $userCheck =  $this->repoUser->findOneBy(array('userKey'=>$data['user_key']));

      if(!$userCheck)
      {
         $mdObject =  $this->repoMaster->findOneBy(array('keyVal'=>'master_key'));

         $masterKey = $mdObject->getValue();

         $request_time_stamp = $data['request_time_stamp'];

         $masterHash = md5($masterKey.$request_time_stamp);

         

      }else{
          return $userCheck;
      }
       //return $this->repoUser->findBy(array('userKey'=>$userKey));
   }


   public function getUser($id)
   {
      $this->setupRepos();
      return $this->repoUser->find($id);

       //return $this->repoUser->findBy(array('userKey'=>$userKey));
   }


   public function createUser($data)
   {
       $this->setupRepos();
       //@todo - add additional validation

       $newUser = new User();

       $data['active'] = 0;

       $data['activation_string']  = md5( rand(0,100).rand(100,200).date(time()) );

       $data['signup_timestamp'] =

       $this->repoUser->basicSave();

   }




    
}
