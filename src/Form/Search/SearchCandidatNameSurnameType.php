<?php

namespace App\Form\Search;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SearchCandidatNameSurnameType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'required' => false,
                'label' => 'Nom :',
                'trim' => true,
                'constraints' => new Length([
                    'min' => 2,
                    'minMessage' => 'Minimum 2 caractères',
                ]),
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Nom du candidat'
                ],
            ])
            ->add('surname', TextType::class, [
                'required' => false,
                'label' => 'Prénom :',
                'trim' => true,
                'constraints' => new Length([
                    'min' => 2,
                    'minMessage' => 'Minimum 2 caractères',
                ]),
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Prénom du candidat'
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
