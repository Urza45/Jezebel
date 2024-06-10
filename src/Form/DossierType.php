<?php

namespace App\Form;

use App\Entity\Admin;
use App\Entity\Client;
use App\Entity\Norme;
use App\Entity\Dossier;
use App\Entity\Society;
use App\Entity\Users;
// use App\Entity\Society;
use Doctrine\ORM\EntityRepository;
use App\Repository\NormeRepository;
use App\Repository\SocietyRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Security\Core\Security;
use App\Repository\AdminRepository;
use App\Repository\NormesAutoriseesRepository;
use PhpParser\Node\Expr\AssignOp\Concat;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class DossierType extends AbstractType
{
    private $security;
    private $societyRepository;
    private $normeRepository;
    private $normesAutoriseesRepository;
    private $repoUsers;

    public function __construct(
        Security $security,
        NormeRepository $repoNorme,
        NormesAutoriseesRepository $normesAutoriseesRepository,
        SocietyRepository $repoSociety,
        AdminRepository $repoUsers
    ) {
        $this->security = $security;
        $this->normeRepository = $repoNorme;
        $this->normesAutoriseesRepository = $normesAutoriseesRepository;
        $this->societyRepository = $repoSociety;
        $this->repoUsers = $repoUsers;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $user = $this->security;
        dump($this->security->getUser()->getSociety()->getId());
        $builder
            ->add(
                'dateDebut',
                DateType::class,
                [
                    'widget' => 'single_text',
                    'attr' => ['class' => 'js-datepicker'],
                ]
            )
            ->add(
                'dateFin',
                DateType::class,
                [
                    'widget' => 'single_text',
                    'attr' => ['class' => 'js-datepicker'],
                ]
            )
            ->add(
                'type',
                ChoiceType::class,
                array(
                    'choices' => array(
                        ' CACES ' => 'CACES',
                        ' Autorisation de conduite' => 'AUTORISATION',
                    ),
                    'multiple' => false, 'expanded' => true
                )
            )
            ->add('adresseIntervention')
            ->add('numDossier')
            ->add('villeIntervention')
            ->add('cpIntervention')
            ->add('commentaires')
            ->add('codeagence');
        if ($user->isGranted('ROLE_ULTRAADMIN')) {
            $builder
                ->add('idClient')
                ->add('idTesteur')
                ->add('idNorme')
                ->add('idFormateur');
        } else {
            $builder->add(
                'idClient',
                EntityType::class,
                [
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
            $builder
                ->add('idTesteur', EntityType::class, [
                    'class' => Admin::class,
                    'choice_label' => 'username',
                    'placeholder' => 'Chosissez une personne',
                    'choices' => $this->repoUsers->findBySociety($this->security->getUser()->getSociety())
                ]);
            $builder->add(
                'idNorme',
                EntityType::class,
                [
                    'class' => Norme::class,
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('qq')
                            ->select('u') // string 'u' is converted to array internally
                            ->from('App\Entity\Norme', 'u')
                            ->from('App\Entity\NormesAutorisees', 'v')
                            ->where('u.id = v.normes')
                            ->andWhere('v.society = :idSociety')
                            ->setParameter('idSociety', $this->security->getUser()->getSociety())
                            ->orderBy('u.label', 'ASC');
                    },
                    'choice_label' => 'label',
                ]
            );
            $builder
                ->add('idFormateur', EntityType::class, [
                    'class' => Admin::class,
                    'choice_label' => 'username',
                    'placeholder' => 'Chosissez une personne',
                    'choices' => $this->repoUsers->findBySociety($this->security->getUser()->getSociety())
                ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'data_class' => Dossier::class,
            ]
        );
    }
}
