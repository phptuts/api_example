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
     *           "groups" = {"full_user"}
     *       }) 
     * @FOS\View(
     *  serializerGroups={"full_user"},
     * )     
     * @param integer $userId the of user we are getting the properties for
     */
    public function getPropertiesAction(Request $request, $userId)
    {
        $properties = $this
                ->get('api_version_one.mappers.database.userpropertiesdatatransfer')
                ->getUserProperties($userId);
        
        return ['properties' => $properties];
    }
    
    /** 
     * Get a single property of the user
     * @ApiDoc(output={
     *           "class"   = "API\VersionOneBundle\APIObjects\UserProperty",
     *           "parsers" = {
     *               "Nelmio\ApiDocBundle\Parser\JmsMetadataParser",
     *               "Nelmio\ApiDocBundle\Parser\ValidationParser"
     *           },
     *           "groups" = {"full_user"}
     *       })      
     * @param Request $request
     * @param int $userId the id of the user property
     * @param int $propertyId the id of the property
     */
    public function getPropertyAction(Request $request, $userId, $propertyId)
    {
       $property = $this
                ->get('api_version_one.mappers.database.userpropertiesdatatransfer')
                ->getProperty($propertyId, $userId);
                
        
        return ['properties' => $property];

    }
    
    /**
     * Updates a user property
     * @ApiDoc(parameters={
     *      {"name"="value", "dataType"="string", "required"=true, "description"="The value you are updating"}
     * },
     *          output={
     *           "class" = "API\VersionOneBundle\APIObjects\UserProperty",
     *           "parsers" = {
     *               "Nelmio\ApiDocBundle\Parser\JmsMetadataParser",
     *               "Nelmio\ApiDocBundle\Parser\ValidationParser"
     *           },
     *           "groups" = {"userproperty_details", "userproperty_list"}
     *       })
     * @param Request $request
     * @param type $userId
     */
    public function patchPropertyAction(Request $request, $userId, $propertyId)
    {
        $value = $request->request->get('value');
        if($value === null)
        {
            return array('errors' => 'value must not be null');
        }
        
        $this->get('api_version_one.mappers.database.userpropertiesdatatransfer')
                ->updateProperty($propertyId, $userId, $value);

        $property = $this
                ->get('api_version_one.mappers.database.userpropertiesdatatransfer')
                ->getProperty($propertyId, $userId);
        return ['properties' => $property];

    }
}
