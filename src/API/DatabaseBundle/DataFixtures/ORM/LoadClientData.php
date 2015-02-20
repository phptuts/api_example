<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace API\DatabaseBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use NoahGlaser\TokenAuthBundle\Entity\Client;

class LoadClientData implements FixtureInterface, OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $client = new Client();
        $client->setName('website-app');
        $client->setDescription('This client is for the website');
        $client->setClientKey(md5(time() . 'website-app'));
        $manager->persist($client);
        $manager->flush();
    }

    public function getOrder()
    {
        return 2;
    }

}
