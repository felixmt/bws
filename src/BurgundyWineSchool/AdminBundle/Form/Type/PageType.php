<?php
// src/BurgundyWineSchool/AdminBundle/Form/Type/PageType.php

namespace BurgundyWineSchool\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', 'text', array('label' => 'Titre', 'attr' => array('class' => 'form-control', 'placeholder' => 'Titre')));
        $builder->add('content', 'textarea', array('label' => 'Contenu', 'attr' => array('class' => 'form-control ckeditor', 'required' => true)));
        $builder->add('isHomepage', 'checkbox', array('label' => 'Utiliser en tant que page d\'accueil', 'attr' => array('class' => 'form-control'), 'required' => false));
        $builder->add('Valider', 'submit', array('attr' => array('class' => 'btn btn-success')));
    }
    
    public function getName()
    {
        return 'page';
    }
    
    public function setDefaultOptions(optionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BurgundyWineSchool\CmsBundle\Entity\Page',
        ));
    }
}