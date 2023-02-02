<?php

namespace App\Controller;

use App\Entity\Dossier;
use App\Entity\Candidat;
use App\Entity\Categoriechoisie;
use App\Repository\NormeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;


/**
 * @Route("/test/pratique")
 */
class TestPratiqueController extends AbstractController
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    /**
     * @Route("/", name="app_test_pratique")
     */
    public function index(
        NormeRepository $normeRepository,
        EntityManagerInterface $entityManager
    ): Response {
        $user = $this->security;

        // Liste des dossiers
        if ($user->isGranted('ROLE_ULTRAADMIN')) {
            $dossiers = $entityManager
                ->getRepository(Dossier::class)
                ->findAll();
        } else {
            $dossiers = $entityManager
                ->getRepository(Dossier::class)
                ->findBySociety($user->getUser()->getSociety()->getId());
        }

        // Liste des candidats
        if ($user->isGranted('ROLE_ULTRAADMIN')) {
            $candidats = $entityManager
                ->getRepository(Candidat::class)
                ->findAll();
        } else {
            $candidats = $entityManager
                ->getRepository(Candidat::class)
                ->findBySociety($user->getUser()->getSociety()->getId());
        }

        $test = $normeRepository->getQuestionnaire(1, 1, 1);

        return $this->render('test_pratique/index.html.twig', [
            'controller_name' => 'TestPratiqueController',
            'dossiers' => $dossiers,
            'candidats' => $candidats,
            'test' => utf8_decode($test),
        ]);
    }

    /**
     * @Route("/{idDossier}/{idCandidat}", name="app_candidat_test_pratique", methods={"GET"})
     */
    public function examenPratique(
        Request $request,
        NormeRepository $normeRepository,
        EntityManagerInterface $entityManager
    ) {
        $candidat = $entityManager
        ->getRepository(Candidat::class)
        ->findById($request->get('idCandidat'));
    
        $dossier = new Dossier($request->get('idDossier'));

        $categorieChoisies = $entityManager
            ->getRepository(Categoriechoisie::class)
            ->findByIdCandidat($candidat);

        $test = $normeRepository->getQuestionnaire($dossier->getIdNorme(), 1, $candidat[0]->getId());

        return $this->render('test_pratique/test_pratique.html.twig', [
            'controller_name' => 'TestPratiqueController',
            'categorieChoisies' => $categorieChoisies,
            'candidat' => $candidat,
            'test' => utf8_decode($test),
        ]);
    }
}
