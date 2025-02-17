<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Car;

class CarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('driver')
            ->add('brand')
            ->add('model')
            ->add('licensePlate')
            ->add('firstLicenseDate')
            ->add('color')
            ->add('seats')
            ->add('isElectric')
            ->add('createdAt')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Car::class,
        ]);
    }
}
