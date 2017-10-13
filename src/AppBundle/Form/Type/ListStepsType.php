<?php

namespace AppBundle\Form\Type;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ListStepsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('steps', CollectionType::class, array(
                'entry_type' => StepType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'prototype' => true,
                'label' => 'Etapes',
                'attr' => array(
                    'class' => 'collection',
                )
            ))
            ->add('notsaveandcancel', SubmitType::class)
            ->add('saveandreturn', SubmitType::class)
            ->add('saveandback', SubmitType::class)
            ->add('saveandadd', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Recipe',
            'validation_groups' => array('recipe_step_init')
        ));
    }

    public function getBlockPrefix()
    {
        return 'ListStepType';
    }
}