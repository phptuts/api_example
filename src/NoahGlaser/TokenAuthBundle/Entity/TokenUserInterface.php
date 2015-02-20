<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace NoahGlaser\TokenAuthBundle\Entity;

/**
 *
 * @author student
 */
interface TokenUserInterface 
{
    public function getRoles();
    public function getUsername();
    public function getId();
    public function getPassword();
    public function getTokens();
    public function setTokens($tokens);
    
}
