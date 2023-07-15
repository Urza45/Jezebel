<?php

namespace App\Form\Search;

use App\Entity\Client;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SearchDossierType extends AbstractType
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
            ->add(
                'numDossier',
                TextType::class,
                [
                    'required' => false,
                    'label' => 'N° Dossier :',
                    'trim' => true,
                    'attr' => [
                        'class' => 'form-control',
                        'placeholder' => 'N° Dossier'
                    ],
                ]
            );
        if ($user->isGranted('ROLE_ULTRAADMIN')) {
            $builder->add(
                'idClient',
                EntityType::class,
                [
                    'required' => false,
                    'label' => 'Client :',
                    'attr' => [
                        'class' => 'form-control',
                        'placeholder' => 'Société cliente'
                    ],
                    'class' => Client::class,
                    'choice_label' => 'nomClient',
                ]
            );
        } else {
            $builder->add(
                'idClient',
                EntityType::class,
                [
                    'required' => false,
                    'label' => 'Client :',
                    'attr' => [
                        'class' => 'form-select',
                        'placeholder' => 'Société cliente'
                    ],
                    'class' => Client::class,
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('qq')
                            ->select('u') // string 'u' is converted to array internally
                            ->from('App\Entity\Client', 'u')
                            // ->from('App\Entity\NormesAutorisees', 'v')
                            // ->where('u.id = v.normes')
                            ->Where('u.society = :idSociety')
                            ->setParameter('idSociety', $this->security->getUser()->getSociety())
                            ->orderBy('u.nomClient', 'ASC');
                    },
                    'choice_label' => 'nomClient',
                ]
            );
        };
        $builder->add(
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
        $resolver->setDefaults(
            [
                // Configure your form options here
            ]
        );
    }
}
