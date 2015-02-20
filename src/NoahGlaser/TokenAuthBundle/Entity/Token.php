<?php

namespace NoahGlaser\TokenAuthBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use NoahGlaser\EntityBundle\Entity\Base;

/**
 * Token
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="NoahGlaser\TokenAuthBundle\Entity\TokenRepository")
 */
class Token extends Base
{
    
    /**
     * @ORM\ManyToOne(targetEntity="Client", inversedBy="tokens")
     * @ORM\JoinColumn(name="client_id", referencedColumnName="id",  nullable=false)
     */
    protected $client;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="expires", type="datetime")
     */
    private $expires;

    
    /**
     * @ORM\ManyToOne(targetEntity="NoahGlaser\TokenAuthBundle\Entity\TokenUserInterface", inversedBy="tokens")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     */
    protected $user;


    /**
     * @var string
     *
     * @ORM\Column(name="token", type="string", length=255, unique=true)
     */
    private $token;

  

    /**
     * Set expires
     *
     * @param \DateTime $expires
     * @return Token
     */
    public function setExpires($expires)
    {
        $this->expires = $expires;

        return $this;
    }

    /**
     * Get expires
     *
     * @return \DateTime 
     */
    public function getExpires()
    {
        return $this->expires;
    }

    /**
     * Set token
     *
     * @param string $token
     * @return Token
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Get token
     *
     * @return string 
     */
    public function getToken()
    {
        return $this->token;
    }
    
    /**
     * Get client
     *
     * @return Client 
     */
    public function getClient()
    {
        return $this->client;
    }
    
    /**
     * Set client
     *
     * @return Token 
     */
    public function setClient($client)
    {
        $this->client = $client;
        return $this;
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
