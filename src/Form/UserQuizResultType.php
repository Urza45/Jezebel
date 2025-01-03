<?php

namespace App\Form;

use App\Entity\UserQuizResult;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserQuizResultType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('id', HiddenType::class)
            ->add(
                'dateTest',
                DateType::class,
                [
                    'widget' => 'single_text',
                    'attr' => ['class' => 'js-datepicker'],
                ]
            )
            ->add('result', HiddenType::class)
            // ->add('result', ChoiceType::class, [
            //     'choices'  => [
            //         'ECHEC' => 'ECHEC',
            //         'RECU' => 'RECU',
            //     ],
            // ])
            ->add('candidat', HiddenType::class)
            ->add('norme', HiddenType::class)
            ->add('quiz', HiddenType::class)
            ->add('enregistrer', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'data_class' => UserQuizResult::class,
            ]
        );
    }
}
