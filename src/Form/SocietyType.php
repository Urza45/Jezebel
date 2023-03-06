<?php

namespace App\Form;

use App\Entity\Society;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SocietyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('address')
            ->add('cp', IntegerType::class, [
                'constraints' => new Length([
                    'min' => 5,
                    'max' => 5,
                    'exactMessage' => 'Exactement 5 chifres.',
                ])
            ])
            ->add('town')
            ->add('logo');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'data_class' => Society::class,
            ]
        );
    }
}
