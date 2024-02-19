<?php

namespace App\Form;

use App\Entity\Player;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewplayerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username')
            ->add('pemail')

            ->add('maingame')
            ->add('maingame', ChoiceType::class, [ 'choices'  => [
                'League of legends' => 'League',
                'valorant' => 'valorant',
                'Fifa' => 'Fifa',
                'Nba' => 'Nba',
                'Need for speed' => 'NFS',
                'Smash bros' => 'Smash bros',
            ],
            ])
            ->add('proll',ChoiceType::class, ['choices' =>[
                'fighter'=>'attack',
                'supporter'=>'suport',
                'tanker'=>'tank',
                'assasin'=>'assasin',],
            ])
            ->add('pambition')

            ->add('lvl',ChoiceType::class, ['choices' =>[
                'low'=>'1',
                'avrage'=>'2',
                'below avrage'=>'3',
                'pro'=>'4',],
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Player::class,
        ]);
    }
}
