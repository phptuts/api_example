<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace NoahGlaser\TokenAuthBundle\Security;

use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Router;
 
class LoginSuccessHandler implements AuthenticationSuccessHandlerInterface
{
	
	protected $router;
	protected $security;
	
	public function __construct(  Router $router, SecurityContext $security)
	{
		$this->router = $router;
		$this->security = $security;
	}
	
	public function onAuthenticationSuccess(Request $request, TokenInterface $token)
	{
		
		if ($this->security->isGranted('ROLE_USER'))
		{
			// redirect the user to where they were before the login process begun.
			$key = $request->get('clientKey');
			$url = $this->router->generate('noah_glaser_token_auth', array('clientKey' => $key));	
                        $response = new RedirectResponse($url);		
		}
			
		return $response;
	}
	
}