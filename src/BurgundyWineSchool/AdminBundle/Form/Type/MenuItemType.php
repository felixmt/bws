<?php
/**
*   MenuItem Type
*
*   PHP version 5.5.12
*
*   @category  PHP
*   @package   AdminBundle
*   @author    Felix MOTOT <felix@motot.fr>
*   @copyright 2015 Félix Motot
*   @license   Sopra http://choosealicense.com/licenses/bsd-2-clause/
*   @link      http://burgundywineschool.com
*/

// src/BurgundyWineSchool/AdminBundle/Form/Type/MenuItemType.php

namespace BurgundyWineSchool\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

/**
* MenuItem Type
*
* @category  PHP
* @package   Trunkadmin
* @author    Felix MOTOT <felix@motot.fr>
* @copyright 2015 Félix Motot
* @license   Sopra http://choosealicense.com/licenses/bsd-2-clause/
* @link      http://soprasteria.com  
*/
class MenuItemType extends AbstractType
{
    /**
    * BuildForm
    *
    * @param FormBuilderInterface $builder form builder
    * @param array                $options options
    *
    * @return void
    */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'name', 'text', array(
                'label' => 'Intitulé Menu', 'attr' => array(
                    'class' => 'form-control', 
                    'maxlength' => '15',
                    'placeholder' => 'Nom de l\'élément de menu'
                )
            )
        );
        $builder->add(
            'route', 'text', array(
                'label' => 'Chemin d\'accès', 
                'attr' => array(
                    'class' => 'form-control',
                    'pattern' => '[A-Za-z]*',
                    'placeholder' => 'chemin'
                )
            )
        );
        $builder->add(
            'page', 'entity', array(
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
            )
        );
        $builder->add(
            'Enregistrer', 'submit', array(
                'attr' => array('class' => 'btn btn-info')
            )
        );
        $builder->add(
            'Valider', 'submit', array('attr' => array('class' => 'btn btn-success'))
        );
    }
    
    /**
    * GetName
    *
    * @return string
    */
    public function getName()
    {
        return 'menuItem';
    }
    
    /**
    * SetDefaultOptions
    *
    * @param optionsResolverInterface $resolver resolver
    *
    * @return void
    */
    public function setDefaultOptions(optionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'BurgundyWineSchool\CmsBundle\Entity\MenuItem',
            )
        );
    }
}