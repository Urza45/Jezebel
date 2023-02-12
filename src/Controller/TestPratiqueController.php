<?php

namespace App\Controller;

use App\Entity\Dossier;
use App\Entity\Candidat;
use App\Entity\Categorie;
use App\Entity\Categoriechoisie;
use App\Entity\Norme;
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

        $categorieChoisies = $entityManager
            ->getRepository(Categoriechoisie::class)
            ->findAll();

        $test = $normeRepository->getQuestionnaire(1, 1, 1);

        return $this->render('test_pratique/index.html.twig', [
            'controller_name' => 'TestPratiqueController',
            'dossiers' => $dossiers,
            'candidats' => $candidats,
            'test' => utf8_decode($test),
            'categorieChoisies' => $categorieChoisies,
        ]);
    }

    /**
     * @Route("/{idDossier}/{idCandidat}/{idCategorie}", name="app_candidat_test_pratique", methods={"GET"})
     */
    public function examenPratique(
        Request $request,
        NormeRepository $normeRepository,
        EntityManagerInterface $entityManager
    ) {

        if (($request->get('note_1') !== null) || ($request->get('note_2') !== null)) {
            // Sauvegarde des notes
            dd($request);
            // Sauvegarde de la date du test
            
            // Ajout du message et redirection
            $this->addFlash('success', 'Test enregistré.');
            return $this->redirectToRoute('app_test_pratique');
        } else {
            $idDossier = $request->get('idDossier');
            $idCandidat = $request->get('idCandidat');
            $idCategorie = $request->get('idCategorie');

            // Récupération du candidat
            $candidat = $entityManager
                ->getRepository(Candidat::class)
                ->findById($idCandidat)[0];

            $dossier = $entityManager
                ->getRepository(Dossier::class)
                ->findById($idDossier)[0];

            $categorie = $entityManager
                ->getRepository(Categorie::class)
                ->find($idCategorie);

            // $categorieChoisies = $entityManager
            // ->getRepository(Categoriechoisie::class)
            // ->findByIdCandidat($candidat);

            $test = $normeRepository->getQuestionnaire($idDossier, $idCategorie, $idCandidat);

            return $this->render('test_pratique/test_pratique.html.twig', [
                'categorieChoisie' => $categorie,
                'dossier' => $dossier,
                'candidat' => $candidat,
                'test' => utf8_decode($test),
            ]);
        }
    }
}
