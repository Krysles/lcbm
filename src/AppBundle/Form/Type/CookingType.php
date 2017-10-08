<?php

namespace AppBundle\Form\Type;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CookingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('selection', TextType::class, array(
                    'label' => 'Sélection')
            )
            ->add('time', TimeType::class, array(
                    'label' => 'Temps',
                    'required' => false,
                    'with_seconds' => true
                )
            )
            ->add('cookingType', EntityType::class, array(
                'class' => 'AppBundle\Entity\CookingType',
                'choice_label' => 'name',
                'multiple' => false,
                'required' => false,
                'label' => 'Type de cuisson',
                'attr' => array(
                    'class' => 'field'
                )
            ))
            ->add('cookingUnity', EntityType::class, array(
                'class' => 'AppBundle\Entity\CookingUnity',
                'choice_label' => 'name',
                'multiple' => false,
                'required' => false,
                'label' => 'Unité de cuisson',
                'attr' => array(
                    'class' => 'field'
                )
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Cooking'
        ));
    }
}