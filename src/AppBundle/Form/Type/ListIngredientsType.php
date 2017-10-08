<?php

namespace AppBundle\Form\Type;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ListIngredientsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ingredients', CollectionType::class, array(
                'entry_type' => IngredientsType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'prototype' => true,
                'attr' => array(
                    'class' => 'collection',
                )
            ))
            ->add('notsaveandcancel', SubmitType::class, array(
                'label' => 'annuler',
                'attr' => array(
                    'class' => 'btn red darken-3 col-md-3',
                    'formnovalidate' => 'formnovalidate'
                )
            ))
            ->add('saveandreturn', SubmitType::class, array(
                'label' => 'Photo',
                'attr' => array(
                    'class' => 'btn red darken-3 col-md-3',
                    'formnovalidate' => 'formnovalidate'
                )
            ))
            ->add('saveandback', SubmitType::class, array(
                'label' => ' Reprendre plus tard',
                'attr' => array(
                    'class' => 'btn red darken-3 col-md-3',
                    'formnovalidate' => 'formnovalidate'
                )
            ))
            ->add('saveandadd', SubmitType::class, array(
                'label' => ' Ajouter les étapes',
                'attr' => array(
                    'class' => 'btn red darken-3 col-md-3',
                    'formnovalidate' => 'formnovalidate'
                )
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Recipe',
            'validation_groups' => array('recipe_ingredient_init')
        ));
    }
}