<?php
/**
*   Appearance Type
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

// src/BurgundyWineSchool/AdminBundle/Form/Type/AppearanceType.php

namespace BurgundyWineSchool\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
* Appearance Type
*
* @category  PHP
* @package   Trunkadmin
* @author    Felix MOTOT <felix@motot.fr>
* @copyright 2015 Félix Motot
* @license   Sopra http://choosealicense.com/licenses/bsd-2-clause/
* @link      http://soprasteria.com  
*/
class AppearanceType extends AbstractType
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
            'file', null, array(
                'label' => 'Image de fond 1er plan'
                , 'attr' => array(
                    'class' => 'input-file', 'id' => 'my-file'
                )
            )
        );
        $builder->add(
            'backgroundImage', null, array(
                'label' => 'Image de fond', 'attr' => array(
                    'class' => 'input-file', 'id' => 'background-image'
                )
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
        return 'appearance';
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
                'data_class' => 'BurgundyWineSchool\AdminBundle\Entity\Appearance',
            )
        );
    }
}