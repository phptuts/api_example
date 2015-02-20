<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CreateClientCommand
 *
 * @author student
 */
namespace NoahGlaser\TokenAuthBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CreateClientCommand extends ContainerAwareCommand
{
    
    
    protected function configure()
    {
        $this
            ->setName('client:create')
            ->setDescription('Creates a new client for the angular app')
            
            ->addArgument(
                'url',
                InputArgument::REQUIRED,
                'The url of the app'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
            
    }
}