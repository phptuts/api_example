<?php

namespace API\DatabaseBundle\Entity;

use Doctrine\ORM\EntityRepository;
use NoahGlaser\TokenAuthBundle\Entity\GetUserInterface;

/**
 * UserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserRepository extends EntityRepository implements GetUserInterface
{
    /**
     * 
     * @param string $username
     * @return User 
     * @throws UsernameNotFoundException
     */
    
    public function loadUserByUsername($username)
    {
        $q = $this
            ->createQueryBuilder('u')
            ->where('u.username = :username OR u.email = :email')
            ->setParameter('username', $username)
            ->setParameter('email', $username)
            ->getQuery();

        try 
        {
            // The Query::getSingleResult() method throws an exception
            // if there is no record matching the criteria.
            $user = $q->getSingleResult();
        } 
        catch (NoResultException $e)
        {
            $message = sprintf(
                'Unable to find an active admin APIDatabaseBundle:User object identified by "%s".',
                $username
            );
            throw new UsernameNotFoundException($message, 0, $e);
        }

        return $user;
    }

}
