<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\Projectweb;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\DataTransformerInterface;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('NomP',TextType::class, [
                'empty_data' => '',])
            ->add('PrixP',TextType::class, [
                'empty_data' => '',])
            ->add('DescP',TextType::class, [
                'empty_data' => '',])
            ->add('StockP')
            ->add('categorie', EntityType::class, [
                'class' => Categorie::class,
                'choice_label' => 'type'
            ])
            ->add('photo', FileType::class, [
                'label' => 'Image',
                'required' => false,
                'mapped' => false,
                'attr' => ['class' => 'form-control custom-input'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Projectweb::class,
        ]);
    }
}

