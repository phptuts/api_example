<?php

namespace API\VersionOneBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\View;
use Symfony\Component\HttpFoundation\Request;
use API\VersionOneBundle\APIObjects\User;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations as FOS;

class UserProperteryController extends FOSRestController
{     
    /**
     * Gets a list of the user properties
     * @ApiDoc(output={
     *           "class"   = "API\VersionOneBundle\APIObjects\UserProperty",
     *           "parsers" = {
     *               "Nelmio\ApiDocBundle\Parser\JmsMetadataParser",
     *               "Nelmio\ApiDocBundle\Parser\ValidationParser"
     *           },
     *           "groups" = {"userproperty_details", "userproperty_list"}
     *       }) 
     * @FOS\View(
     *  serializerGroups={"userproperty_details", "userproperty_list"},
     * )     
     * @param Request $request
     * @param integer $userId the of user we are getting the properties for
     */
    public function getPropertiesAction(Request $request, $userId)
    {
        
    }
    
    /** 
     * Get a single property of the user
     * @ApiDoc(output={
     *           "class"   = "API\VersionOneBundle\APIObjects\UserProperty",
     *           "parsers" = {
     *               "Nelmio\ApiDocBundle\Parser\JmsMetadataParser",
     *               "Nelmio\ApiDocBundle\Parser\ValidationParser"
     *           },
     *           "groups" = {"userproperty_details", "userproperty_list"}
     *       })      
     * @param Request $request
     * @param int $userId the id of the user property
     * @param int $propertyId the id of the property
     */
    public function getPropertyAction(Request $request, $userId, $propertyId)
    {
        
    }
    
    /**
     * Updates a user property
     * @ApiDoc()
     * @param Request $request
     * @param type $userId
     */
    public function putPropertyAction(Request $request, $userId, $propertyId)
    {
       
    }
}
