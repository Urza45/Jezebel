<?php

namespace App\Form;

use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomClient')
            ->add('adresseClient')
            ->add(
                'cpClient',
                IntegerType::class,
                [
                    'constraints' => new Length(
                        [
                            'min' => 5,
                            'max' => 5,
                            'exactMessage' => 'Exactement 5 chifres.',
                        ]
                    ),
                ]
            )
            ->add('villeClient')
            ->add('codeagence');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'data_class' => Client::class,
            ]
        );
    }
}
