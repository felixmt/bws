<?php
// src/BurgundyWineSchool/AdminBundle/Form/Type/AppearanceType.php

namespace BurgundyWineSchool\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AppearanceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('file', null, array('label' => 'Image de fond 1er plan', 'attr' => array('class' => 'input-file', 'id' => 'my-file')));
        $builder->add('backgroundImage', null, array('label' => 'Image de fond', 'attr' => array('class' => 'input-file', 'id' => 'background-image')));
        $builder->add('Valider', 'submit', array('attr' => array('class' => 'btn btn-success')));
    }
    
    public function getName()
    {
        return 'appearance';
    }
    
    public function setDefaultOptions(optionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BurgundyWineSchool\AdminBundle\Entity\Appearance',
        ));
    }
}