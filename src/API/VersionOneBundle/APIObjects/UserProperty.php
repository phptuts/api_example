<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UserProperty
 *
 * @author student
 */
namespace API\VersionOneBundle\APIObjects;

use Hateoas\Configuration\Annotation as Hateoas;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;



/**
 * 
 * @Hateoas\Relation(
 *      "self", 
 *      exclusion = @Hateoas\Exclusion(groups={"full_user"}),
 *       href = @Hateoas\Route(
 *         "api_1_get_user_property",
 *          parameters = { 
 *                         "userId" = "expr(object.getUserId())",
 *                         "propertyId" = "expr(object.getId())"
 *                       }
 *      )
 * )
 * 
 * @Hateoas\Relation(
 *      "parent", 
 *      exclusion = @Hateoas\Exclusion(groups={"full_user"}),
 *       href = @Hateoas\Route(
 *         "api_1_get_user",
 *          parameters = { 
 *                         "userId" = "expr(object.getUserId())"
 *                       }
 *      )
 * )
 * 
 */
class UserProperty 
{
    
  
    
    /** 
      * The user id 
      * @JMS\Until("1")
      * @JMS\Groups({"userproperty_list", "full_user"}) 
      * @JMS\Type("integer")
      */
    public $userId;
    
    /** 
      * The name of the property 
      * @JMS\Until("1")
      * @JMS\Groups({"userproperty_list", "full_user"}) 
      * @JMS\Type("string")
      */
    public $name;
    
    /** 
      * The properties actual value
      * @JMS\Until("1")
      * @JMS\Groups({"userproperty_list", "full_user"}) 
      * @JMS\Type("string")
      * @Assert\NotBlank(groups={"editproperty"}, message="user_value_blank")
      */
    public $value;
    
    /** 
      * The id of the property
      * @JMS\Until("1")
      * @JMS\Groups({"userproperty_list", "full_user"}) 
      * @JMS\Type("integer")
      * @Assert\NotBlank(groups={"editproperty"}, message="user_id_blank")
      * 
      */
    public $id;
    
    /** 
      * The date the property was created
      * @JMS\Until("1")
      * @JMS\Groups({"userproperty_list", "full_user"}) 
      * @JMS\Type("DateTime<'m/d/Y'>")
      */
    public $createdAt;
    
    /** 
      * The date the property was updated
      * @JMS\Until("1")
      * @JMS\Groups({"userproperty_details", "full_user"}) 
      * @JMS\Type("DateTime<'m/d/Y'>")
      */
    public $updatedAt;
    
    function getName() 
    {
        return $this->name;
    }

    function getValue() 
    {
        return $this->value;
    }

    function getId() 
    {
        return $this->id;
    }

    function getCreatedAt()
    {
        return $this->createdAt;
    }

    function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    function setName($name) 
    {
        $this->name = $name;
    }

    function setValue($value) 
    {
        $this->value = $value;
    }

    function setId($id) 
    {
        $this->id = $id;
    }

    function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    function getUserId()
    {
        return $this->userId;
    }
    
    function setUserId($userId)
    {
        $this->userId = $userId;
    }
    
    
}
