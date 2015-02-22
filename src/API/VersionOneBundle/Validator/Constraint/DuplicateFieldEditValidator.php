<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DuplicateFieldValidator
 *
 * @author student
 */
namespace API\VersionOneBundle\Validator\Constraint;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class DuplicateFieldEditValidator extends ConstraintValidator
{
    private $em;
    private $tokenStorage;
    
    public function __construct(EntityManager $em, TokenStorage $tokenStorage) 
    {
        $this->em = $em;
        $this->tokenStorage = $tokenStorage;
    } 
    
    public function validate($value, Constraint $constraint) 
    {
        $result =  $this->em
                        ->getRepository($constraint->entityname)
                        ->findBy(array($constraint->fieldname => $value));
        
        $methodName = 'get' . ucfirst($constraint->fieldname);
        $userValue = $this->tokenStorage->getToken()->getUser()->{$methodName}(); 
        
        if(count($result) > 0 && $userValue != $value)
        {
             $this->context->addViolation($constraint->message);
        }
        
    }

}
