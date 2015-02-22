<?php

namespace API\DatabaseBundle\Security\Voter;

use Symfony\Component\Security\Core\Authorization\Voter\AbstractVoter;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;


class UserVoter extends AbstractVoter
{
    const EDIT = 'user_edit';

    
    protected function getSupportedAttributes() 
    {
        return array(self::EDIT);
    }

    protected function getSupportedClasses() 
    {
       return array('API\DatabaseBundle\Entity\User'); 
    }

    protected function isGranted($attribute, $object, $user = null) 
    {
        if (!$user instanceof AdvancedUserInterface) 
        {
            return false;
        }
        
        if(in_array('ROLE_ADMIN', $user->getRoles()) || $object->getId() === $user->getId())
        {
            return true;
        }
        
        return false;
    }

}
