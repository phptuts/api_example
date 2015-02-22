<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace API\VersionOneBundle\Mappers\Database;

use Doctrine\ORM\EntityManager;
use API\DatabaseBundle\Entity\UserRepository;
use API\VersionOneBundle\APIObjects\User as APIUser;
use API\VersionOneBundle\APIObjects\UserProperty;
use API\DatabaseBundle\Entity\User as DBUser;
use Doctrine\ORM\NoResultException;
use API\DatabaseBundle\Entity\UserProperties;

class UserDataTransfer
{
    /**
     * @var EntityManager  
     */
    private $em;
    
    /**
     * @var UserRepository 
     */
    private $userRepo;
    
    
    private $securityencoder;
    
    public function __construct(EntityManager $em, UserRepository $userRepo, $securityencoder) 
    {
        $this->em = $em;
        $this->userRepo = $userRepo;
        $this->securityencoder = $securityencoder;
    }
    
    public function getUsers($page = 0)
    {
       $userResults = [];
       
       $users = $this->userRepo->findBy(array(), array(), 10, $page * 10);
       
       foreach($users as $user)
       {
           $userResults[] = $this->populateUserObjectWithoutChildren($user);
       }
       
       return $userResults;
    }
    
    public function getSingleUser($id)
    {
        $user = $this->userRepo->find($id);
        $apiuser = $this->populateUserObjectWithoutChildren($user);
        $apiuser = $this->populateUserWithUserProperties($apiuser, $user);
        return $apiuser;
    }
    
    
    private function populateUserWithUserProperties(APIUser $userAPI, DBUser $userDB)
    {
        $properties = $userDB->getUserproperties();
        $props = [];
        foreach($properties as $prop)
        {
            $props[] =
                    UserPropertiesDataTransfer::populateUserProperty($prop, $userDB->getId());
        }
        
        $userAPI->setProperties($props);
        return $userAPI;
    }
    
    private function populateUserObjectWithoutChildren($user)
    {
       $user_api = new APIUser();
       $user_api->setEmail($user->getEmail());
       $user_api->setId($user->getId());
       $user_api->setUsername($user->getUsername());
       $user_api->setCreatedAt($user->getCreatedAt());
       $user_api->setUpdatedAt($user->getUpdatedAt());
       return $user_api;
    }
    
    public function createUser(APIUser $user)
    {
        $userdb = new DBUser();
        $userdb->setUsername($user->getUsername());
        $userdb->setEmail($user->getEmail());
        $userdb->setRoles(array("ROLE_USER"));
        $userdb->setIsActive(false);
        $userdb->setSecretKey(md5(time()));
        $encoder = $this->securityencoder->getEncoder($userdb);
        $userdb->setPassword($encoder->encodePassword($user->getPlainpassword(), $userdb->getSalt()));

        $prop1 = new UserProperties();
        $prop1->setName('facebook');
        $prop1->setValue('');
        $userdb->addUserproperty($prop1);
        
        $prop2 = new UserProperties();
        $prop2->setName('twitter');
        $prop2->setValue('');
        $userdb->addUserproperty($prop2);        
        
        $this->em->persist($userdb);
        $this->em->flush();
        
        return $userdb;
        
    }
    
    public function activateUser($userId, $secretCode)
    {
        $user = $this->userRepo->find($userId);
        if($user != null && $user->getSecretKey() === $secretCode)
        {
            $user->setIsActive(true);
            $user->setSecretKey("");
            $this->em->persist($user);
            $this->em->flush();
            return true;
        }
        
        return false;
    }
    
    public function sendResetPassword($email)
    {
        $user = $this->userRepo->findOneBy(array('email' => $email));
        if($user === null)
        {
            return false;
        }
        $user->setSecretKey(md5(time()));
        $this->em->persist($user);
        $this->em->flush();
        return true;
    }
    
    public function resetPassword($userId, $email, $password, $secretCode)
    {
        $user = $this->userRepo->findOneBy(array('id' => $userId, 'email' => $email, 'secretKey' => $secretCode));
        if($user === null)
        {
            return false;
        }
                
        $encoder = $this->securityencoder->getEncoder($user);
        $user->setPassword($encoder->encodePassword($password, $user->getSalt()));
        $user->setSecretKey("");
        $this->em->persist($user);
        $this->em->flush();
        return true;
        
    }
    
    public function updateUser(DBUser $userdb, APIUser $userAPI)
    {
        if(!empty($userAPI->getUsername()))
        {
            $userdb->setUsername($userAPI->getUsername());
        }
        
        if(!empty($userAPI->getEmail()))
        {
            $userdb->setEmail($userAPI->getEmail());
        }
        
        foreach($userdb->getUserproperties() as $dbProp)
        {
            foreach($userAPI->getProperties() as $userProp)
            {
                if($dbProp->getId() == $userProp->getId())
                {
                    $dbProp->setValue($userProp->getValue());
                }
            }
        }
        
        $this->em->persist($userdb);
        $this->em->flush();
        
        return $this->getSingleUser($userdb->getId());
    }
    
    
}
