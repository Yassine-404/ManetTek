<?php

namespace App\Form;

use App\Entity\Reservations;
use App\Entity\Tournements;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ReservationsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // Ajouter un champ "niveau" avec ChoiceType
            ->add('niveau', ChoiceType::class, [
                'choices' => [
                    'Beginner' => 'beginner',
                    'Amateur' => 'amateur',
                    'Semi-Pro' => 'semi-pro',
                    'Professional' => 'professional',
                    'World Class' => 'world class',
                    'Legendary' => 'legendary',
                ],
                'placeholder' => 'Choose a level',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservations::class,
        ]);
    }
}
