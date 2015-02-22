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


class EditProperty extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('id');
        $builder->add('value');
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver) 
    {
        return $resolver->setDefaults(array(
            'data_class' => 'API\VersionOneBundle\APIObjects\UserProperty',
            'validation_groups' => array('editproperty')
        ));
    }
    
    public function getName() 
    {
        return 'editproperty';
    }

}
