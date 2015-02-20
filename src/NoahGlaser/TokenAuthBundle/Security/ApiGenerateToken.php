<?php

namespace NoahGlaser\TokenAuthBundle\Security;

use NoahGlaser\TokenAuthBundle\Entity\TokenUserInterface;
use NoahGlaser\TokenAuthBundle\Entity\Token;
use Doctrine\ORM\EntityManager;
use NoahGlaser\TokenAuthBundle\Entity\ClientRepository;

class ApiGenerateToken
{
    private $clientrepo;
    
    private $secondToAddForExpire;
    
    private $em;
    
    public function __construct( ClientRepository $clientrepo, EntityManager $em, $seconds)
    {
        $this->clientrepo = $clientrepo;
        $this->secondToAddForExpire = $seconds;
        $this->em = $em;
    }
    
    public function saveTokenToDatabase(TokenUserInterface $user, $clientId)
    {
        $tokenhash = $this->createNewToken($user);
        $client = $this->clientrepo->findOneBy(array('clientKey' => $clientId));
        $token = new Token();
        $token->setClient($client);
        $token->setToken($tokenhash);
        $rightnow = new \DateTime();
        $rightnow->modify("+" . $this->secondToAddForExpire . " seconds");
        $token->setExpires($rightnow);
        $token->setUser($user);
        $this->em->persist($token);
        $this->em->flush();
        return $tokenhash;
        
    }
    
    public function createNewToken(TokenUserInterface $user)
    {
        $id = $user->getId();
        $password = $user->getPassword();
        $username = $user->getUsername();
        return hash('sha512', $username . $id . $password . time());
    }
}
