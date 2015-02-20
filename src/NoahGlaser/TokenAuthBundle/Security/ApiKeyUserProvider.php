<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace NoahGlaser\TokenAuthBundle\Security;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use NoahGlaser\TokenAuthBundle\Entity\TokenRepository;
use NoahGlaser\TokenAuthBundle\Entity\GetUserInterface;

class ApiKeyUserProvider implements UserProviderInterface
{
    private $tokenRepo;
    private $getUserInfo;
    private $userClass;
    
    public function __construct(TokenRepository $repo, GetUserInterface $getUserInfo, $userClass) 
    {
        $this->tokenRepo = $repo;
        $this->getUserInfo = $getUserInfo;
        $this->userClass = $userClass;
    }
    
    public function getUsernameForApiKey($apiKey)
    {
        // Look up the username based on the token in the database, via
        // an API call, or do something entirely different
        /** @var NoahGlaser\TokenAuthBundle\Entity\Token $token **/
        $token = $this->tokenRepo->findValidToken($apiKey);
        
        if(!empty($token))
        {
            return $token->getUser()->getUsername();
        }
        
        return null;
        
    }

    public function loadUserByUsername($username)
    {
        return $this->getUserInfo->loadUserByUsername($username);
    }

    public function refreshUser(UserInterface $user)
    {
        // this is used for storing authentication in the session
        // but in this example, the token is sent in each request,
        // so authentication can be stateless. Throwing this exception
        // is proper to make things stateless
        throw new UnsupportedUserException();
    }

    public function supportsClass($class)
    {
        return $this->userClass === $class;
    }
}