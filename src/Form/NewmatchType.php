<?php

namespace App\Form;

use App\Entity\Pmatch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewmatchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type',ChoiceType::class,['choices'=>[
                '5V5'=>10,
                '3V3'=>6,
                '1V1'=>2,
            ]])
            ->add('idp')
            ->add('game', ChoiceType::class, [ 'choices'  => [
                'League of legends' => 'League',
                'valorant' => 'valorant',
                'Fifa' => 'Fifa',
                'Nba' => 'Nba',
                'Need for speed' => 'NFS',
                'Smash bros' => 'Smash bros',
            ],
            ])
            ->add('pwd', TextType::class, [
                'required' => false,
            ]);

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Pmatch::class,
        ]);
    }
}
