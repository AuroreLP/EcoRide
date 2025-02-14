<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // Étape 1 : Inscription de base
        $builder
            ->add('username', TextType::class, [
                'constraints' => [new NotBlank(['message' => 'Username is required'])],
            ])
            ->add('name', TextType::class, [
                'constraints' => [new NotBlank(['message' => 'Name is required'])],
            ])
            ->add('firstname', TextType::class, [
                'constraints' => [new NotBlank(['message' => 'Firstname is required'])],
            ])
            ->add('email', EmailType::class, [
                'constraints' => [new NotBlank(['message' => 'Email is required'])],
            ])
            ->add('password', PasswordType::class, [
                'constraints' => [new NotBlank(['message' => 'Password is required'])],
            ]);

        // Étape 2 : Complétion des infos utilisateur (si on est à l'étape 2)
        if ($options['step'] === 2) {
            $builder
                ->add('roles', ChoiceType::class, [
                    'choices' => [
                        'Passager' => 'ROLE_USER',
                        'Conducteur' => 'ROLE_DRIVER',
                    ],
                    'expanded' => true,
                    'multiple' => true,
                ])
                ->add('phone', TextType::class, [
                    'constraints' => [new NotBlank(['message' => 'Numéro de téléphone obligatoire'])],
                ])
                ->add('isDriver', CheckboxType::class, [
                    'required' => false, // Permettre l'inscription sans être conducteur
                ])
                ->add('birthDate', DateType::class, [
                    'widget' => 'single_text',
                    'constraints' => [new NotBlank(['message' => 'La date de naissance est requise'])],
                ])
                ->add('photo', FileType::class, [
                    'required' => false, // L'utilisateur peut ne pas ajouter de photo immédiatement
                ])
                ->add('createdAt', DateType::class, [
                    'widget' => 'single_text',
                    'data' => new \DateTime(), // Définit automatiquement la date actuelle
                    'disabled' => true, // Empêche l'utilisateur de modifier ce champ
                ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'step' => 1, // Défaut : étape 1
        ]);
    }
}
