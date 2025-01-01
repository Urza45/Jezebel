<?php

namespace App\Form\Factures;

use App\Entity\Factures\Devis;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class DevisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('numero')
            ->add('date')
            ->add('tva')
            ->add('acompte')
            ->add('nom')
            ->add('adresse')
            ->add('adresse2')
            ->add('codePostal')
            ->add('ville')
            ->add('telephone', TextType::class)
            ->add(
                'lignes',
                CollectionType::class,
                [
                    'label' => 'Prestations',
                    'allow_add' => true,
                    'allow_delete' => true,
                    'by_reference' => false,
                    // 'prototype' => true,
                    'entry_type' => LigneType::class,
                    'entry_options' => ['label' => false],
                    'by_reference' => false,
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Devis::class,
        ]);
    }
}
