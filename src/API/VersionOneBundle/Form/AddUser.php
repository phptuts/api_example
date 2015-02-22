<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace API\VersionOneBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormBuilderInterface;

class AddUser extends AbstractType
{
    
    
    public function buildForm(FormBuilderInterface $builder, array $options) 
    {
        $builder->add('username');
        $builder->add('plainpassword');
        $builder->add('email');
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver) 
    {
       $resolver->setDefaults(array(
           'data_class' => 'API\VersionOneBundle\APIObjects\User',
           'validation_groups' => array('adduser')
       ));
    }
    
    
    public function getName() 
    {
        return 'adduser';
    }
}
