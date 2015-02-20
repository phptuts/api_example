<?php

namespace API\DatabaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use NoahGlaser\EntityBundle\Entity\Base;

/**
 * UserProperties
 *
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="API\DatabaseBundle\Entity\UserPropertiesRepository")
 */
class UserProperties extends Base
{

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="userproperties")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     */
    private $user;
    
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="value", type="text")
     */
    private $value;


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
     * Set name
     *
     * @param string $name
     * @return UserProperties
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set value
     *
     * @param string $value
     * @return UserProperties
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return string 
     */
    public function getValue()
    {
        return $this->value;
    }
    
    public function getUser()
    {
        return $this->user;
    }
    
    public function setUser($user)
    {
        $this->user = $user;
        
        return $this;
    }
}
