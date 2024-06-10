<?php

namespace App\Form\Factures;

use App\Entity\Factures\Devis;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

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
            ->add('telephone')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Devis::class,
        ]);
    }
}
