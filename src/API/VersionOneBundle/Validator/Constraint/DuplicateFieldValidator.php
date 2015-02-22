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

class DuplicateFieldValidator extends ConstraintValidator
{
    private $em;
    
    public function __construct(EntityManager $em) 
    {
        $this->em = $em;
    } 
    
    public function validate($value, Constraint $constraint) 
    {
        $result =  $this
                        ->em
                        ->getRepository($constraint->entityname)
                        ->findBy(array($constraint->fieldname => $value));
        
        if(count($result) > 0)
        {
             $this->context->addViolation($constraint->message);
        }
        
    }

}
