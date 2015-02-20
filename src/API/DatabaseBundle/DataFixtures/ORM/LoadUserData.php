<?php
namespace API\DatabaseBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use API\DatabaseBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadUserData implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername('nglaser');
        $user->setEmail('nglaser@gmail.com');
        $user->setRoles(array("ROLE_USER"));
        $user->setIsActive(true);
        
        $encoder = $this->container
            ->get('security.encoder_factory')
            ->getEncoder($user);
        
        $user->setPassword($encoder->encodePassword('password', $user->getSalt()));

        $manager->persist($user);
        $manager->flush();
    }
    
    public function getOrder()
    {
        return 1;
    }
}