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


class EditUser extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('email');
        $builder->add('username');
        $builder->add('id');
        $builder->add('properties', 'collection', 
                array(
                    'type'         => new EditProperty(),
                    'allow_add'    => true,
                    'allow_delete' => true,
                    'cascade_validation' => true,
                    'error_bubbling' => false
                    ));
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        return $resolver->setDefaults(array(
            'data_class' => 'API\VersionOneBundle\APIObjects\User',
            'validation_groups' => array('edituser', 'editproperty'),
            'cascade_validation' => true

        ));
    }
    
    public function getName()
    {
        return 'edituser';
    }

}
