<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace API\VersionOneBundle\Mappers\Database;

use Doctrine\ORM\EntityManager;
use API\DatabaseBundle\Entity\UserPropertiesRepository;
use API\VersionOneBundle\APIObjects\User as APIUser;
use API\VersionOneBundle\APIObjects\UserProperty;
use API\DatabaseBundle\Entity\User as DBUser;
use Doctrine\ORM\NoResultException;
use API\DatabaseBundle\Entity\UserProperties;
use API\DatabaseBundle\Entity\UserRepository;

class UserPropertiesDataTransfer 
{
    /**
     * @var EntityManager  
     */
    private $em;
    
    /**
     * @var UserPropertiesRepository 
     */
    private $userPropRepo;
    
    /**
     * @var UserRepository 
     */
    private $userRepo;
    
    public function __construct(EntityManager $em,
            UserPropertiesRepository $userPropRepo, UserRepository $userRepo) 
    {
        $this->em = $em;
        $this->userPropRepo = $userPropRepo;
        $this->userRepo = $userRepo;
    }
    
    public function getUserProperties($userId)
    {
        $user = $this->userRepo->find($userId);
        $properties = $this->userPropRepo->findBy(array('user' => $user));
        $apiprops = [];
        foreach($properties as $prop)
        {
            $apiprops[] = self::populateUserProperty($prop, $userId);
        }
        
        return $apiprops;
    }
    
    public function getProperty($propertyId, $userId)
    {
        $user = $this->userRepo->find($userId);
        $property = $this
                ->userPropRepo
                ->findOneBy(array('user' => $user, 'id' => $propertyId));
        return self::populateUserProperty($property, $userId);
    }
    
    public function updateProperty($propertyId, $userId, $value)
    {
        $user = $this->userRepo->find($userId);
        $property = $this
                ->userPropRepo
                ->findOneBy(array('user' => $user, 'id' => $propertyId));
        $property->setValue($value);
        $this->em->persist($property);
        $this->em->flush();
        

    }
    
    public static function populateUserProperty($prop, $userId)
    {
        $value = $prop->getValue();
        $name  = $prop->getName();
        $createdAt = $prop->getCreatedAt();
        $updatedAt = $prop->getUpdatedAt();
        $id = $prop->getId();
            
        $propAdd = new UserProperty();
        $propAdd->setCreatedAt($createdAt);
        $propAdd->setUpdatedAt($updatedAt);
        $propAdd->setUserId($userId);
        $propAdd->setId($id);
        $propAdd->setValue($value);
        $propAdd->setName($name);
        
        return $propAdd;
    }
    
}
