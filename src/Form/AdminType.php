<?php

namespace App\Form;

use App\Entity\Admin;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Security\Core\Security;

class AdminType extends AbstractType
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $user = $this->security;

        $builder
            ->add('username');
        //->add('roles')
        if ($user->isGranted('ROLE_ULTRAADMIN')) {
            $builder->add(
                'roles',
                ChoiceType::class,
                [
                    'required' => true,
                    'multiple' => false,
                    'expanded' => false,
                    'choices'  => [
                        'Moniteur' => 'ROLE_MOD',
                        'Administrateur' => 'ROLE_ADMIN',
                        'Superadministrateur' => 'ROLE_SUPERADMIN',
                    ],
                ]
            );
        } else {
            $builder->add(
                'roles',
                ChoiceType::class,
                [
                    'required' => true,
                    'multiple' => false,
                    'expanded' => false,
                    'choices'  => [
                        'Moniteur' => 'ROLE_MOD',
                        'Administrateur' => 'ROLE_ADMIN',
                    ],
                ]
            );
        }
        $builder
            ->add('password', PasswordType::class)
            ->add('society');
        // Data transformer
        $builder->get('roles')
            ->addModelTransformer(
                new CallbackTransformer(
                    function ($rolesArray) {
                        // transform the array to a string
                        return count($rolesArray) ? $rolesArray[0] : null;
                    },
                    function ($rolesString) {
                        // transform the string back to an array
                        return [$rolesString];
                    }
                )
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'data_class' => Admin::class,
            ]
        );
    }
}
