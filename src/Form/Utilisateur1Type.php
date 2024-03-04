<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Utilisateur1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            //->add('roles')
            ->add('password')
            ->add('email')
            ->add('prenom')
            ->add('role', ChoiceType::class, [
                'placeholder' => 'Choisir un role',
                'choices' => [
                    'Coach' => 'Coach',
                    'Streamer' => 'Streamer',
                    'Joueur' => 'Joueur',
                    'Client' => 'Client',
                ],
                ])
            ->add('isVerified')
            ->add('adress')
            ->add('ville')
            ->add('zipcode')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
