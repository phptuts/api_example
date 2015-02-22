<?php

namespace API\VersionOneBundle\APIObjects;

use Hateoas\Configuration\Annotation as Hateoas;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;
use API\VersionOneBundle\Validator\Constraint as APIAssert;

//One space per @
/**
 * 
 * @Hateoas\Relation(
 *      "self", 
 *      exclusion = @Hateoas\Exclusion(groups={"user_list", "full_user"}),
 *       href = @Hateoas\Route(
 *         "api_1_get_user",
 *          parameters = { "userId" = "expr(object.getId())" }
 *      )
 * )
 * 
 * @Hateoas\Relation(
 *      "all", 
 *      exclusion = @Hateoas\Exclusion(groups={"user_list", "full_user"}),
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
      * @JMS\Groups({ "adduser", "full_user", "user_list"}) 
      * @JMS\Type("string")
      * @Assert\NotBlank(groups={"adduser"}, message="user_username_blank")
      * @Assert\Length(groups={"adduser", "edituser"}, min=3, max=12, minMessage="user_username_length", maxMessage="user_username_length")
      * @APIAssert\DuplicateField(groups={"adduser"},message="user_username_exists", fieldname="username", entityname="APIDatabaseBundle:User")
      * @APIAssert\DuplicateFieldEdit(groups={"edituser"},message="user_username_exists", fieldname="username", entityname="APIDatabaseBundle:User")

      */
    public $username;
        
     /** 
      * The email address of the user
      * @JMS\Until("1")
      * @JMS\Groups({ "adduser", "full_user", "user_list", "resetpassword"})
      * @JMS\Type("string")
      * @Assert\NotBlank(groups={"adduser"}, message="user_email_blank")
      * @Assert\Email(groups={"adduser", "edituser"}, message="user_email_invalid_email")
      * @APIAssert\DuplicateField(groups={"adduser"}, message="user_email_exists", fieldname="email", entityname="APIDatabaseBundle:User")
      * @APIAssert\DuplicateFieldEdit(groups={"edituser"}, message="user_email_exists", fieldname="email", entityname="APIDatabaseBundle:User")
      */
    public $email;
    
     /**
      * The Id of the user
      * @JMS\Until("1")
      * @JMS\Groups({ "full_user", "user_list"}) 
      * @Assert\NotBlank(groups={"edituser"}, message="user_id_blank")
      * @JMS\Type("integer")
      */
    public $id;
    
    /**
     * When the user was created
     * @JMS\Until("1")
     * @JMS\Groups({"full_user", "user_list"})
     * @JMS\Type("DateTime<'m/d/Y'>")
     */
    public $createdAt;
    
     /**
      * When the user was last updated
      * @JMS\Until("1")
      * @JMS\Groups({"full_user", "user_list"}) 
      * @JMS\Type("DateTime<'m/d/Y'>")
      */
    public $updatedAt;
    
    /** 
      * plain password
      * @JMS\Until("1")
      * @JMS\Groups({"adduser"}) 
      * @JMS\Type("string")
      * @Assert\Length(groups={"adduser"}, min=8, max=16, minMessage="user_password_length", maxMessage="user_password_length")
      * @Assert\NotBlank(groups={"adduser"}, message="user_password_blank")
      */
    private $plainpassword;
    
    
    /**
     * list of user properties
     * @JMS\Until("1")
     * @JMS\Groups({ "full_user"})
     * @JMS\Type("array<API\VersionOneBundle\APIObjects\UserProperty>")
     */
    public $properties;
    

    
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
