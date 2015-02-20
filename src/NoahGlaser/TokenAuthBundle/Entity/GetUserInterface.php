<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace NoahGlaser\TokenAuthBundle\Entity;


interface GetUserInterface 
{
    public function loadUserByUsername($username);
}
