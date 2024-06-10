<?php

namespace App\Form;

use App\Entity\NormesAutorisees;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Regex;

class NormesAutoriseesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('society')
            ->add('normes')
            ->add('pricePerCandidate', MoneyType::class, [
                'label' => 'Prix par candidat (HT) : ',
                'scale' => 2,
            ])
            ->add('pricePerGroup', MoneyType::class, [
                'label' => 'Prix par groupe (HT) : ',
                'scale' => 2,
            ])
            ->add('pricePerMonitor', MoneyType::class, [
                'label' => 'Prix par instructeur (HT) : ',
                'scale' => 2,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'data_class' => NormesAutorisees::class,
            ]
        );
    }
}
