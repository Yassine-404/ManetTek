<?php

namespace App\Form;

use App\Entity\Tournements;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType; // Ajout de cette ligne
use Symfony\Component\Form\Extension\Core\Type\UrlType; // Ajout de cette ligne
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TournementsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('jeu')
            ->add('date')
            ->add('lieu')
            ->add('description')
            ->add('availableSlots')
            ->add('prix') // Ajout du champ pour le prix
            ->add('tournementImage', FileType::class, [
                'label' => 'Tournament Image',
                'mapped' => false,
                'required' => false,
            ])
            ->add('tournementVideo', FileType::class, [
                'label' => 'Tournament Video',
                'mapped' => false,
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Tournements::class,
        ]);
    }
}
