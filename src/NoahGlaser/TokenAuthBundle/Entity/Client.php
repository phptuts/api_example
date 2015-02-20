<?php

namespace NoahGlaser\TokenAuthBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use NoahGlaser\EntityBundle\Entity\Base;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Client
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="NoahGlaser\TokenAuthBundle\Entity\ClientRepository")
 */
class Client extends Base 
{
    
    public function __construct()
    {
        $this->tokens = new ArrayCollection();
    }
    
    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="Token", mappedBy="client")
     */
    protected $tokens;
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="clientKey", type="string", length=255, unique=true)
     */
    private $clientKey;

    /**
     * Set name
     *
     * @param string $name
     * @return Client
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
     * Set description
     *
     * @param string $description
     * @return Client
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
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
    
    public function setClientKey($clientKey)
    {
        $this->clientKey = $clientKey;
        return $this;
    }
    
    public function getClientKey()
    {
        return $this->clientKey;
    }
}
