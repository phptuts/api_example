<?php

namespace NoahGlaser\TokenAuthBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * TokenRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TokenRepository extends EntityRepository
{
    public function findValidToken($token)
    {
        $dql = "SELECT t FROM " . 
               "NoahGlaserTokenAuthBundle:Token t " .  
               "WHERE t.expires > :rightnow  AND t.token = :token";
        
        return $this->getEntityManager()
                    ->createQuery($dql)
                    ->setParameter('rightnow', new \DateTime())
                    ->setParameter('token', $token)
                    ->getSingleResult();
                   
                   
    }
}
