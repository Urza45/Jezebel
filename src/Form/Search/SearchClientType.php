<?php

namespace App\Form\Search;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SearchClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('client', TextType::class, [
                'required' => false,
                'label' => 'Société :',
                'trim' => true,
                'constraints' => new Length([
                    'min' => 2,
                    'minMessage' => 'Minimum 2 caractères',
                ]),
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Nom de la société'
                ],
            ])
            ->add('ville', TextType::class, [
                'required' => false,
                'label' => 'Ville :',
                'trim' => true,
                'constraints' => new Length([
                    'min' => 2,
                    'minMessage' => 'Minimum 2 caractères',
                ]),
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Nom de la ville'
                ],
            ])
            ->add(
                'submit',
                SubmitType::class,
                [
                    'label' => 'Rechercher',
                    'attr' => ['class' => 'form-control btn btn-success'],
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
