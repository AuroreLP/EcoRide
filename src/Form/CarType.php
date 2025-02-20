<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Car;

class CarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('user', TextType::class, [
                'label' => 'Conducteur',
            ])
            ->add('brand', TextType::class, [
                'label' => 'Marque',
            ])
            ->add('model', TextType::class, [
                'label' => 'Modèle',
            ])
            ->add('licensePlate', TextType::class, [
                'label' => 'Plaque d\'immatriculation',
            ])
            ->add('firstLicenseDate', DateType::class, [
                'label' => 'Date de première immatriculation',
                'widget' => 'single_text',
                'required' => false,
            ])
            ->add('color', TextType::class, [
                'label' => 'Couleur',
            ])
            ->add('seats', IntegerType::class, [
                'label' => 'Places disponibles',
                'attr' => [
                    'min' => 1,
                    'max' => 5,
                    'step' => 1, // L'utilisateur peut choisir des nombres entiers uniquement
                ],
            ])
            ->add('isElectric', CheckboxType::class, [
                'label' => 'Voiture électrique',
                'required' => false, // Par défaut, la case n'est pas cochée
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Car::class,
        ]);
    }
}
