<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace API\VersionOneBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CreateClientController extends Controller
{
    public function createClientAction(Request $request)
    {
        $clientManager = $this->container->get('fos_oauth_server.client_manager.default');
        $client = $clientManager->createClient();
        $client->setName('angular example');
        $client->setRedirectUris(array('URL' => 'http://angularexample.dev'));
        $client->setAllowedGrantTypes(array('token', 'authorization_code', 'password'));
        
        return Response("IT WORKED!!");
    }
}
