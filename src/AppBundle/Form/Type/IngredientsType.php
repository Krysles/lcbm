<?php

namespace AppBundle\Form\Type;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class IngredientsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('quantity', IntegerType::class, array(
                'attr' => array(
                    'class' => 'field'
                ),
                'label' => 'Quantité')
            )
            ->add('unity', EntityType::class, array(
                'class' => 'AppBundle\Entity\Unity',
                'choice_label' => 'name',
                'multiple' => false,
                'required' => false,
                'label' => 'Unité',
                'attr' => array(
                    'class' => 'field'
                )
            ))
            ->add('liaison', EntityType::class, array(
                'class' => 'AppBundle\Entity\Liaison',
                'choice_label' => 'name',
                'multiple' => false,
                'required' => false,
                'label' => 'Liaison',
                'attr' => array(
                    'class' => 'field'
                )
            ))
            ->add('ingredient', EntityType::class, array(
                'class' => 'AppBundle\Entity\Ingredient',
                'choice_label' => 'name',
                'multiple' => false,
                'required' => false,
                'label' => 'Ingrédient',
                'attr' => array(
                    'class' => 'field'
                )
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\RecipeIngredient'
        ));
    }

    public function getBlockPrefix()
    {
        return 'IngredientsType';
    }
}