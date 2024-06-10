<?php

namespace App\Form\Factures;

use App\Entity\Factures\TVA;
use App\Entity\Factures\Facture\Ligne;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;

class LigneType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // ->add('id')
            ->add('description')
            ->add('quantite')
            ->add('prix', MoneyType::class)
            ->add(
                'tva',
                EntityType::class,
                [
                    'class' => TVA::class,
                    'choice_label' => 'libelle',
                    'choice_value' => 'tva'
                ]
            )
            // ->add('facture')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'data_class' => Ligne::class,
            ]
        );
    }
}
