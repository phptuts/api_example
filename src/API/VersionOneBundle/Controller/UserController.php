<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace API\VersionOneBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations as FOS;
use Symfony\Component\HttpFoundation\Request;
use API\VersionOneBundle\APIObjects\User;
use API\VersionOneBundle\APIObjects\UserProperty;

/**
 * Description of UserController
 *
 * @author student
 */

class UserController extends FOSRestController
{
    /**
     * Gets a list of users
     * @FOS\View(
     *  serializerGroups={"user_list"},
     * )
     * @ApiDoc(output={
     *           "class"   = "API\VersionOneBundle\APIObjects\User",
     *           "parsers" = {
     *               "Nelmio\ApiDocBundle\Parser\JmsMetadataParser",
     *               "Nelmio\ApiDocBundle\Parser\ValidationParser"
     *           },
     *           "groups" = {"user_list"}
     *       })      
     */
    public function getUsersAction(Request $request)
    {
        $user1 = new User();
        $user1->setCreatedAt(new \DateTime());
        $user1->setEmail('b@gmail.com');
        $user1->setUpdatedAt(new \DateTime());
        $user1->setUsername('bmane');
        $user1->setId(3);
        
        $user2 = new User();
        $user2->setCreatedAt(new \DateTime());
        $user2->setEmail('c@gmail.com');
        $user2->setUpdatedAt(new \DateTime());
        $user2->setUsername('cmane');
        $user2->setId(4);

        return  ['users' => [$user1, $user2]];
    }
    
    
    /**
     * Get a single user  
     * @ApiDoc(output={
     *           "class"   = "API\VersionOneBundle\APIObjects\User",
     *           "parsers" = {
     *               "Nelmio\ApiDocBundle\Parser\JmsMetadataParser",
     *               "Nelmio\ApiDocBundle\Parser\ValidationParser"
     *           },
     *           "groups" = {"user_list", "user_details", "userproperty_list"}
     *       })    
     * @FOS\View(
     *  serializerGroups={"user_list", "user_details", "userproperty_list"}
     * )   
     * @param int $userId the id of the user
     * @return User
     */
    public function getUserAction(Request $request, $userId)
    {
        $user = new User();
        $user->setCreatedAt(new \DateTime());
        $user->setEmail('b@gmail.com');
        $user->setUpdatedAt(new \DateTime());
        $user->setUsername('bmane');
        $user->setId($userId);
        
        $userprop1 = new UserProperty();
        $userprop1->setName('facebook');
        $userprop1->setValue('noah.glaser.75');
        $userprop1->setId(2);
        $userprop1->setUpdatedAt(new \DateTime());
        $userprop1->setCreatedAt(new \DateTime());
        $userprop1->setUserId($userId);
        
        $userprop2 = new UserProperty();
        $userprop2->setName('twitter');
        $userprop2->setValue('thesqlman');
        $userprop2->setId(3);
        $userprop2->setUserId($userId);
        $userprop2->setUpdatedAt(new \DateTime());
        $userprop2->setCreatedAt(new \DateTime());

        $userproperties = array();
        $userproperties[] = $userprop1;
        $userproperties[] = $userprop2;
        $user->setProperties($userproperties);
        
        return $user;
    }
    
    public function postUserAction(Request $request)
    {
        
    }
    
    public function deleteUserAction(Request $request, $userId)
    {
        
    }
    
    
}
