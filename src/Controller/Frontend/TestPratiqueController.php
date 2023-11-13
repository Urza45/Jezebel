<?php

namespace App\Controller\Frontend;

use App\Entity\Dossier;
use App\Entity\Candidat;
use App\Entity\Categorie;
use App\Entity\Categoriechoisie;
use App\Entity\Norme;
use App\Repository\CandidatRepository;
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
    /**
     * index
     *
     * @param NormeRepository        $normeRepository
     * @param CandidatRepository     $candidatRepository
     * @param EntityManagerInterface $entityManager
     *
     * @Route("/", name="app_test_pratique")
     *
     * @return void
     */
    public function index(
        NormeRepository $normeRepository,
        CandidatRepository $candidatRepository,
        EntityManagerInterface $entityManager
    ): Response {
        // Liste des dossiers et des candidats
        if ($this->isGranted('ROLE_ULTRAADMIN')) {
            $dossiers = $entityManager
                ->getRepository(Dossier::class)
                ->findBy([], ['id' => 'desc']);
            $candidats = $entityManager
                ->getRepository(Candidat::class)
                ->findAll();
        } else {
            $dossiers = $entityManager
                ->getRepository(Dossier::class)
                ->findBy(['society' => $this->getUser()->getSociety()], ['id' => 'desc']);
            $candidats = $entityManager
                ->getRepository(Candidat::class)
                ->findBySociety($this->getUser()->getSociety()->getId());
        }

        $categorieChoisies = $entityManager
            ->getRepository(Categoriechoisie::class)
            ->findAll();

        // foreach ($candidats as $candidat) {
        //     $userQuizResults = $candidat->get();
        //     foreach ($userQuizResults as $userQuizResult) {
        //         $form[$userQuizResult->getId()] = $this->createForm(UserQuizResultType::class, $userQuizResult);
        //         // $form[$userQuizResult->getId()]->handleRequest($userQuizResult);
        //         $formView[$userQuizResult->getId()] = $form[$userQuizResult->getId()]->createView();
        //     }
        // }

        //$test = $normeRepository->getQuestionnaire(1, 1, 1);

        //$test2 = $candidatRepository->resultatsCategorie(5, 6);

        return $this->render(
            'test_pratique/index.html.twig',
            [
                'controller_name' => 'TestPratiqueController',
                'dossiers' => $dossiers,
                'candidats' => $candidats,
                //'test' => utf8_decode($test),
                'categorieChoisies' => $categorieChoisies,
                //'test2' => $test2
            ]
        );
    }

    /**
     * @Route("/{idDossier}/{idCandidat}/{idCategorie}", name="app_candidat_test_pratique", methods={"GET"})
     */
    public function examenPratique(
        Request $request,
        NormeRepository $normeRepository,
        CandidatRepository $candidatRepository,
        EntityManagerInterface $entityManager
    ) {

        if (($request->get('note_1') !== null) || ($request->get('note_2') !== null)) {
            // Sauvegarde des notes
            $idCandidat = $request->get('id_candidat');
            $idCategorie = $request->get('id_categorie');
            $candidat = $candidatRepository->findOneById($idCandidat);
            $candidat->setDatePratique(new \DateTime());

            $candidatRepository->saveNotes(
                $idCandidat,
                $idCategorie,
                $request->get('increment'),
                $request->get('critere_id'),
                $request->get('note_1'),
                $request->get('note_2')
            );
            // Sauvegarde de la date du test
            $entityManager->persist($candidat);
            $entityManager->flush();
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

            return $this->render(
                'test_pratique/test_pratique.html.twig',
                [
                    'categorieChoisie' => $categorie,
                    'dossier' => $dossier,
                    'candidat' => $candidat,
                    'test' => utf8_decode($test),
                ]
            );
        }
    }
}
