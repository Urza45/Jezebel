<?php

namespace App\Form;

use App\Entity\ParametersSociety;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ParametersSocietyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('codeDossier')
            ->add('incCodeDossier')
            ->add('codeFacture')
            ->add('incCodeFacture')
            ->add('codeConvention')
            ->add('incCodeConvention')
            ->add('codeDevis')
            ->add('incCodeDevis')
            ->add('codeConvocation')
            ->add('incCodeConvocation')
            ->add('idSociety')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ParametersSociety::class,
        ]);
    }
}
