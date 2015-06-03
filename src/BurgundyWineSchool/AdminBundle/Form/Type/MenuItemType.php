<?php
// src/BurgundyWineSchool/AdminBundle/Form/Type/MenuItemType.php

namespace BurgundyWineSchool\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class MenuItemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text', array('label' => 'Intitulé Menu', 'attr' => array(
            'class' => 'form-control', 
            'maxlength' => '15',
            'placeholder' => 'Nom de l\'élément de menu'
        )));
        $builder->add('route', 'text', array(
            'label' => 'Chemin d\'accès', 
            'attr' => array(
                'class' => 'form-control',
                'pattern' => '[A-Za-z]*',
                'placeholder' => 'chemin'
            )
        ));
        $builder->add('page', 'entity', array(
            'label' => 'Article associé',
            'empty_value' => 'Choisissez un article',
            'required' => false,
            'class' => 'BurgundyWineSchool\CmsBundle\Entity\Page',
            'property' => 'title',
            // 'query_builder' => function(EntityRepository $er) {
                // return $er->createQueryBuilder('u')
                    // ->where('u.menuItem IS NULL');
            // },
            'read_only' => false, 
            'attr' => array('class' => 'form-control')  
        ));
        $builder->add('Valider', 'submit', array('attr' => array('class' => 'btn btn-success')));
    }
    
    public function getName()
    {
        return 'menuItem';
    }
    
    public function setDefaultOptions(optionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BurgundyWineSchool\CmsBundle\Entity\MenuItem',
        ));
    }
}