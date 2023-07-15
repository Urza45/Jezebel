<?php

namespace App\Form;

use App\Entity\ContactClient;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('adresse')
            ->add('adresse2')
            ->add('codePostal')
            ->add('ville')
            ->add('telephone1')
            ->add('telephone2')
            ->add('email')
            ->add('client');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
            'data_class' => ContactClient::class,
            ]
        );
    }
}
