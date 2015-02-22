<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TokenController
 *
 * @author student
 */
namespace NoahGlaser\TokenAuthBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use NoahGlaser\TokenAuthBundle\Security\ApiGenerateToken;

class TokenController extends Controller 
{
    
    public function generateTokenAction(Request $request)
    {
               
        $clientKey = $request->query->get('clientKey');
        $token = $this
                 ->get('noahglaser.tokenauth.security.apigeneratetoken')
                 ->saveTokenToDatabase($this->getUser(),$clientKey );
        
        return new JsonResponse(array('token' => $token));

    }
        
  
    
    public function loginFailureAction()
    {
        return new Response('invalid credentials', 401);
    }
    
}
