<?php

namespace App\Form;

use App\Entity\Candidat;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class CandidatType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomCandidat')
            ->add('prenomCandidat')
            ->add(
                'dateNaissance', DateType::class, [
                'widget' => 'single_text',
                'attr' => ['class' => 'js-datepicker'],
                ]
            )
            ->add('dureeExperience')
            ->add('heureFormation')
            ->add(
                'dateTheorique', DateType::class, [
                'widget' => 'single_text',
                'attr' => ['class' => 'js-datepicker'],
                ]
            )
            ->add(
                'datePratique', DateType::class, [
                'widget' => 'single_text',
                'attr' => ['class' => 'js-datepicker'],
                ]
            )
            ->add('noteFormation')
            ->add('experienceProduction')
            ->add('idDossier')
            ->add('idStatus')
            ->add('formationRecue')
            ->add('idNiveauCompetence')
            ->add('idClient');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
            'data_class' => Candidat::class,
            ]
        );
    }
}
