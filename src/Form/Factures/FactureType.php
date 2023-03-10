<?php

namespace App\Form\Factures;

use App\Entity\Factures\TVA;
use App\Entity\Factures\Facture;
use App\Form\Factures\LigneType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class FactureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('numero')
            ->add('date')
            // ->add('tva', EntityType::class, [
            //     'class' => TVA::class,
            //     'choice_label' => 'libelle'
            // ])
            ->add('acompte')
            ->add('reference')
            ->add('nom')
            ->add('adresse')
            ->add('adresse2')
            ->add('code_postal')
            ->add('ville')
            ->add('telephone')
            ->add('lignes', CollectionType::class, [
                'label' => 'Prestations',
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                // 'prototype' => true,
                'entry_type' => LigneType::class,
                'entry_options' => ['label' => false],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Facture::class,
        ]);
    }
}
