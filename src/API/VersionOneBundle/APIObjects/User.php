<?php

namespace API\VersionOneBundle\APIObjects;

use Hateoas\Configuration\Annotation as Hateoas;
use JMS\Serializer\Annotation as JMS;
//One space per @
/**
 * @Hateoas\Relation(
 *      "delete",
 *      exclusion = @Hateoas\Exclusion(groups={"user_list"}),
 *      href = @Hateoas\Route(
 *         "api_1_delete_user",
 *          parameters = { "userId" = "expr(object.getId())" }
 *      )
 * )
 * 
 * @Hateoas\Relation(
 *      "self", 
 *      exclusion = @Hateoas\Exclusion(groups={"user_list"}),
 *       href = @Hateoas\Route(
 *         "api_1_get_user",
 *          parameters = { "userId" = "expr(object.getId())" }
 *      )
 * )
 * 
 * @Hateoas\Relation(
 *      "all", 
 *      exclusion = @Hateoas\Exclusion(groups={"user_list"}),
 *       href = @Hateoas\Route(
 *         "api_1_get_users"
 *      )
 * ) 
 */


class User 
{
     /** 
      * The username of the user
      * @JMS\Until("1")
      * @JMS\Groups({"user_list"}) 
      * @JMS\Type("string")
      */
    public $username;
        
     /** 
      * The email address of the user
      * @JMS\Until("1")
      * @JMS\Groups({"user_list"})
      * @JMS\Type("string")
      */
    public $email;
    
     /**
      * The Id of the user
      * @JMS\Until("1")
      * @JMS\Groups({"user_list"}) 
      * @JMS\Type("integer")
      */
    public $id;
    
    /**
     * When the user was created
     * @JMS\Until("1")
     * @JMS\Groups({"user_list"})
     * @JMS\Type("DateTime<'m/d/Y'>")
     */
    public $createdAt;
    
     /**
      * When the user was last updated
      * @JMS\Until("1")
      * @JMS\Groups({"user_list"}) 
      * @JMS\Type("DateTime<'m/d/Y'>")
      */
    public $updatedAt;
    
    
    /**
     * list of user properties
     * @JMS\Until("1")
     * @JMS\Groups({"user_details"})
     * @JMS\Type("array<API\VersionOneBundle\APIObjects\UserProperty>")
     */
    public $properties;
    
    /** 
      * plain password
      * @JMS\Until("1")
      * @JMS\Groups({"not_listed"}) 
      * @JMS\Type("string")
      */
    private $plainpassword;
    
    function getProperties() 
    {
        return $this->properties;
    }

    function setProperties(array $properties) 
    {
        $this->properties = $properties;
    }

        
    function getUsername() 
    {
        return $this->username;
    }

    function getEmail() 
    {
        return $this->email;
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

    function setUsername($username) 
    {
        $this->username = $username;
    }

    function setEmail($email)
    {
        $this->email = $email;
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

    function getPlainpassword() 
    {
        return $this->plainpassword;
    }

    function setPlainpassword($plainpassword) 
    {
        $this->plainpassword = $plainpassword;
    }


    

}
