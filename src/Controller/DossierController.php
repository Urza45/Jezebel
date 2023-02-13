<?php

namespace App\Controller;

use App\Entity\Dossier;
use App\Entity\Society;
use App\Entity\Candidat;
use App\Entity\Categorie;
use App\Entity\Categoriechoisie;
use App\Form\DossierType;
use App\Form\CandidatType;
use App\Form\ChoiceCategoriesType;
use App\Repository\NormeRepository;
use App\Repository\SocietyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use App\Repository\NormesAutoriseesRepository;
use DateTime;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/dossier")
 */
class DossierController extends AbstractController
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    /**
     * @Route("/", name="app_dossier_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $user = $this->security;

        if ($user->isGranted('ROLE_ULTRAADMIN')) {
            $dossiers = $entityManager
                ->getRepository(Dossier::class)
                ->findAll();
        } else {
            $dossiers = $entityManager
                ->getRepository(Dossier::class)
                ->findBySociety($user->getUser()->getSociety()->getId());
        }

        // $dossiers = $entityManager
        //     ->getRepository(Dossier::class)
        //     ->findAll();

        return $this->render('dossier/index.html.twig', [
            'dossiers' => $dossiers,
        ]);
    }

    /**
     * @Route("/new", name="app_dossier_new", methods={"GET", "POST"})
     */
    public function new(
        Request $request,
        EntityManagerInterface $entityManager,
        NormesAutoriseesRepository $normesAutoriseesRepository,
        NormeRepository $normeRepository,
        SocietyRepository $societyRepository
    ): Response {
        $user = $this->security;

        $dossier = new Dossier();

        $societeEnCours = new Society();
        $societeEnCours = $societyRepository->findOneById($user->getUser()->getSociety()->getId());

        $form = $this->createForm(DossierType::class, $dossier);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $societeEnCours = $societyRepository->findOneById($user->getUser()->getSociety()->getId());
            $dossier->setSociety($societeEnCours);
            $entityManager->persist($dossier);
            $entityManager->flush();

            return $this->redirectToRoute('app_dossier_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('dossier/new.html.twig', [
            'dossier' => $dossier,
            'form' => $form,
            // 'liste' => $listAutorisees,
        ]);
    }

    /**
     * @Route("/{id}", name="app_dossier_show", methods={"GET"})
     */
    public function show(Dossier $dossier): Response
    {
        return $this->render('dossier/show.html.twig', [
            'dossier' => $dossier,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_dossier_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Dossier $dossier, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DossierType::class, $dossier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_dossier_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('dossier/edit.html.twig', [
            'dossier' => $dossier,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_dossier_delete", methods={"POST"})
     */
    public function delete(Request $request, Dossier $dossier, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $dossier->getId(), $request->request->get('_token'))) {
            $entityManager->remove($dossier);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_dossier_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/{id}/add_candidat", name="app_dossier_add_candidat", methods={"GET", "POST"})
     */
    public function addCandidat(
        Dossier $dossier,
        Request $request,
        EntityManagerInterface $entityManager
    ) {
        $candidat = new Candidat();
        $candidat->setIdDossier($dossier);
        $norme = $dossier->getIdNorme();
        $categories = $entityManager
            ->getRepository(Categorie::class)
            ->findByIdNorme($norme);
        foreach ($categories as $key => $value) {
            $listCategories[$value->getLabelCourt()] = $value->getId();
        }

        $form2 = $this->createForm(ChoiceCategoriesType::class, $listCategories);
        $form2->handleRequest($request);

        if ($form2->isSubmitted() && $form2->isValid()) {
            $data = $form2->getData();

            $candidat->setDateNaissance($data['dateNaissance']);
            $candidat->setNomCandidat($data['nomCandidat']);
            $candidat->setPrenomCandidat($data['prenomCandidat']);
            $candidat->setIdClient($dossier->getIdClient());
            $candidat->setSociety($dossier->getSociety());

            if ($data['type'] == null) {
                $this->addFlash('notice', 'Vous devez choisir au moins une catégorie');
            } else {
                $entityManager->persist($candidat);
                $entityManager->flush();
                foreach ($data['type'] as $key => $value) {
                    $categorie = $entityManager
                        ->getRepository(Categorie::class)
                        ->findOneById($value);
                    $categoriesChoisies = new Categoriechoisie();
                    $categoriesChoisies
                        ->setIdCandidat($candidat)
                        ->setIdCategory($categorie);
                    $entityManager->persist($categoriesChoisies);
                    $entityManager->flush();
                }
                $this->addFlash('success', 'Candidat créé avec success');
            }
        }

        return $this->renderForm('candidat/new.html.twig', [
            'candidat' => $candidat,
            // 'form' => $form,
            'form2' => $form2,
            'retour' => 'Dossier',
        ]);
    }
}
