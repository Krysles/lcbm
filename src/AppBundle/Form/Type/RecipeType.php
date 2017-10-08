<?php

namespace AppBundle\Form\Type;

use AppBundle\Form\Type\PictureType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RecipeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('subcategories', EntityType::class, array(
                'class' => 'AppBundle\Entity\Subcategory',
                'choice_label' => 'name',
                'multiple' => true,
                'required' => true
            ))
            ->add('name', TextType::class)
            ->add('description', TextareaType::class)
            ->add('period', ChoiceType::class, array(
                'choices' => array(
                    'printemps' => 'printemps',
                    'paques' => 'paques',
                    'été' => 'été',
                    'automne' => 'automne',
                    'halloween' => 'halloween',
                    'hiver' => 'hiver',
                    'noël' => 'noël',
                    "jour de l'an" => "jour de l'an"
                )
            ))
            ->add('personNb', RangeType::class, array(
                'attr' => array(
                    'min' => 1,
                    'max' => 24,
                    'value' => 4
                )
            ))
            ->add('budgetType', ChoiceType::class, array(
                'choices' => array(
                    'économique' => 'économique',
                    'normal' => 'normal',
                    'assez cher' => 'assez cher',
                    'très cher' => 'très cher'
                )
            ))
            ->add('difficulty', ChoiceType::class, array(
                'choices' => array(
                    'très facile' => 'très facile',
                    'facile' => 'facile',
                    'intermédiaire' => 'intermédiaire',
                    'difficile' => 'difficile'
                )
            ))
            ->add('preparationTime', TimeType::class)
            ->add('timeToRest', TimeType::class)
            ->add('cookingTime', TimeType::class)
            ->add('notsaveandcancel', SubmitType::class, array(
                'label' => 'annuler',
                'attr' => array(
                    'class' => 'btn red darken-3 col-md-3'
                )
            ))
            ->add('saveandback', SubmitType::class, array(
                'label' => ' Reprendre plus tard',
                'attr' => array(
                    'class' => 'btn red darken-3'
                )
            ))
            ->add('saveandadd', SubmitType::class, array(
                'label' => ' Ajouter la photo',
                'attr' => array(
                    'class' => 'btn red darken-3'
                )
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Recipe',
            'validation_groups' => array('recipe_init')
        ));
    }
}