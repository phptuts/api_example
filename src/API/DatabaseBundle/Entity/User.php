<?php

namespace API\DatabaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use NoahGlaser\EntityBundle\Entity\Base;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use NoahGlaser\TokenAuthBundle\Entity\TokenUserInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * User
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="API\DatabaseBundle\Entity\UserRepository")
 */
class User extends Base implements AdvancedUserInterface, \Serializable, TokenUserInterface
{

    public function __construct()
    {
        $this->tokens = new ArrayCollection();
    }
 
    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="NoahGlaser\TokenAuthBundle\Entity\Token", mappedBy="user")
     */
    protected $tokens;
    
    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="UserProperties", mappedBy="user")
     */
    protected $userproperties;
    
    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=255)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=100)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=200)
     */
    private $email;

    /**
     * @var array
     *
     * @ORM\Column(name="roles", type="array")
     */
    private $roles;

    /**
     * @var boolean
     *
     * @ORM\Column(name="isActive", type="boolean")
     */
    private $isActive;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set username
     *
     * @param string $username
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string 
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set roles
     *
     * @param array $roles
     * @return User
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Get roles
     *
     * @return array 
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return User
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean 
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    public function eraseCredentials() 
    {
        return !$this->isActive;
    }

    public function getSalt() 
    {
        return null;
    }

    public function isAccountNonExpired() 
    {
        return true;
    }

    public function isAccountNonLocked() 
    {
        return true;
    }

    public function isCredentialsNonExpired() 
    {
        return true;
    }

    public function isEnabled() 
    {
        return $this->isActive;
    }
    
    
    /**
     * @see \Serializable::serialize()
     */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->email
            // see section on salt below
            // $this->salt,
        ));
    }

    /**
     * @see \Serializable::unserialize()
     */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->email
            // see section on salt below
            // $this->salt
        ) = unserialize($serialized);
    }
    
   /**
     * Get all the tokens for a client
     *
     * @return ArrayCollection 
     */
    public function getTokens()
    {
        return $this->tokens;
    }
    
    /**
     * sets the tokens
     *
     * @return Token 
     */
    public function setTokens($tokens)
    {
        foreach($tokens as $token)
        {
            $this->addToken($token);
        }
        
        return $this;
    }
    
    /**
     * adds a token to the collection
     * 
     */
    public function addToken($token)
    {
        $this->tokens->add($token);
    }
    
    public function getUserproperties()
    {
        return $this->userproperties;
    }
    
    public function setUserproperty($properties)
    {
        foreach($properties as $property)
        {
            $this->addUserproperty($property);
        }
    }
    
    public function addUserproperty($property)
    {
        $property->setUser($this);
        $this->userproperties->add($property);
    }
    
    public function removeUserproperty($property)
    {
        $this->userproperties->removeElement($property);
    }


}
