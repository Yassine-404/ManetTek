<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
class UtilisateurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('nom', null, [
            'constraints' => [
                new Assert\NotBlank(['message' => 'Le nom ne peut pas être vide']),
                new Assert\Regex([
                    'pattern' => '/^[a-zA-ZÀ-ÿ\s]+$/',
                    'message' => 'Le nom ne peut contenir que des lettres.'
                ]),
                new Assert\Length([
                    'min' => 4,
                    'maxMessage' => 'Le nom ne peut pas dépasser {{ limit }} caractères.'
                ])
            ]
        ])
            ->add('password', null, [
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length([
                        'min' => 8,
                        'minMessage' => 'Le mot de passe doit contenir au moins {{ limit }} caractères.'
                    ]),
                    // Ajoutez d'autres contraintes de validation au besoin
                ],
            ])
            ->add('email', null, [
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Email(['message' => 'L\'adresse email "{{ value }}" n\'est pas valide.']),
                ],
            ])
            ->add('prenom', null, [
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Regex([
                        'pattern' => '/^[a-zA-Z\s]+$/',
                        'message' => 'Le prénom ne peut contenir que des lettres.'
                    ]),
                    new Assert\Length([
                        'min' => 4,
                        'max' => 255,
                        'minMessage' => 'Le prénom doit contenir au moins {{ limit }} caractères.',
                        'maxMessage' => 'Le prénom ne peut pas dépasser {{ limit }} caractères.'
                    ]),
                ],
            ])
            ->add('role', ChoiceType::class, [
                'placeholder' => 'Choisir un role',
                'choices' => [
                    'Coach' => 'Coach',
                    'Streamer' => 'Streamer',
                    'Joueur' => 'Joueur',
                    'Client' => 'Client',
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                ],
            ])
            ->add('isVerified')
            ->add('adress')
            ->add('ville')
            ->add('zipcode');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
