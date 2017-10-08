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

class DeviceType extends AbstractType
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
            ->add('deviceType', EntityType::class, array(
                'class' => 'AppBundle\Entity\DeviceType',
                'choice_label' => 'name',
                'multiple' => false,
                'required' => false,
                'label' => "Appareil utilisé",
                'attr' => array(
                    'class' => 'field'
                )
            ))
            ->add('deviceMode', EntityType::class, array(
                'class' => 'AppBundle\Entity\DeviceMode',
                'choice_label' => 'name',
                'multiple' => false,
                'required' => false,
                'label' => "Mode de l'appareil",
                'attr' => array(
                    'class' => 'field'
                )
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Device'
        ));
    }
}