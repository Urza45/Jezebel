<?php

namespace App\Controller\Frontend;

use App\Services\PDF;
use App\Entity\Dossier;
use App\Entity\Society;
use App\Entity\Candidat;
use App\Entity\Categorie;
use App\Form\DossierType;
use App\Entity\Categoriechoisie;
use App\Form\ChoiceCategoriesType;
use App\Repository\ClientRepository;
use App\Repository\DossierRepository;
use App\Repository\SocietyRepository;
use App\Form\Search\SearchDossierType;
use App\Repository\CandidatRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use phpDocumentor\Reflection\DocBlock\Tags\Var_;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/dossier")
 */
class DossierController extends AbstractController
{
    /**
     * index
     *
     * @param Request           $request
     * @param DossierRepository $dossierRepository
     * @param Session $session
     *
     * @Route("/", name="app_dossier_index", methods={"GET","POST"})
     *
     * @return Response
     */
    public function index(
        Request $request,
        DossierRepository $dossierRepository,
        Session $session
    ): Response {
        $form = $this->createForm(SearchDossierType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $numDossier = $form->get('numDossier')->getData();
            $idClient = $form->get('idClient')->getData();
            // $prenom = $form->get('fieldTwo')->getData();
            $dossiers = $dossierRepository->searchByNumClient($numDossier, $idClient);
        } else {
            if ($this->isGranted('ROLE_ULTRAADMIN')) {
                $dossiers = $dossierRepository->findAll();
            } else {
                $dossiers = $dossierRepository->findBySociety($session->get('SOCIETE')->getId());
            }
        }

        return $this->render(
            'dossier/index.html.twig',
            [
                'dossiers' => $dossiers,
                'form' => $form->createView()
            ]
        );
    }

    /**
     * new
     *
     * @param Request                $request
     * @param EntityManagerInterface $entityManager
     * @param SocietyRepository      $societyRepository
     * @param Session $session
     *
     * @Route("/new", name="app_dossier_new", methods={"GET", "POST"})
     *
     * @return void
     */
    public function new(
        Request $request,
        EntityManagerInterface $entityManager,
        SocietyRepository $societyRepository,
        Session $session
    ): Response {
        $dossier = new Dossier();

        $societeEnCours = new Society();

        $form = $this->createForm(DossierType::class, $dossier);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $societeEnCours = $societyRepository->findOneById($session->get('SOCIETE')->getId());
            $dossier->setSociety($societeEnCours);
            $entityManager->persist($dossier);
            $entityManager->flush();

            return $this->redirectToRoute('app_dossier_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm(
            'dossier/new.html.twig',
            [
                'dossier' => $dossier,
                'form' => $form,
            ]
        );
    }

    /**
     * show
     *
     * @param Dossier $dossier
     *
     * @Route("/{id}", name="app_dossier_show", methods={"GET"})
     *
     * @return Response
     */
    public function show(Dossier $dossier, CandidatRepository $candidatRepository): Response
    {
        $candidats = $candidatRepository->findByIdDossier($dossier->getId());

        return $this->render(
            'dossier/show.html.twig',
            [
                'dossier' => $dossier,
                'candidats' => $candidats
            ]
        );
    }

    /**
     * edit
     *
     * @param Request                $request
     * @param Dossier                $dossier
     * @param EntityManagerInterface $entityManager
     *
     * @Route("/{id}/edit", name="app_dossier_edit", methods={"GET", "POST"})
     *
     * @return Response
     */
    public function edit(Request $request, Dossier $dossier, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DossierType::class, $dossier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($dossier);
            $entityManager->flush();

            return $this->redirectToRoute('app_dossier_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm(
            'dossier/edit.html.twig',
            [
                'dossier' => $dossier,
                'form' => $form,
            ]
        );
    }

    /**
     * delete
     *
     * @param Request                $request
     * @param Dossier                $dossier
     * @param EntityManagerInterface $entityManager
     *
     * @Route("/{id}", name="app_dossier_delete", methods={"POST"})
     *
     * @return Response
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
     * addCandidat
     *
     * @param mixed $dossier
     * @param mixed $request
     * @param mixed $entityManager
     *
     * @Route("/{id}/add_candidat", name="app_dossier_add_candidat", methods={"GET", "POST"})
     *
     * @return void
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

        return $this->renderForm(
            'candidat/new.html.twig',
            [
                'candidat' => $candidat,
                // 'form' => $form,
                'form2' => $form2,
                'retour' => 'Dossier',
            ]
        );
    }

    /**
     * PrintDossier
     *
     * @param \App\Entity\Dossier $dossier
     * 
     *  @Route("/{id}/print_dossier", name="app_dossier_pdf", methods={"GET", "POST"})
     * 
     * @return void
     */
    public function PrintDossier(Dossier $dossier, ClientRepository $clientRepository, ManagerRegistry $registry, Security $security) {
        $fpdf = new PDF();

        $clients = $clientRepository->findById($dossier->getIdClient());
        $client = $clients[0];

        $fpdf->setLogo('./images/logo/' . $this->getUser()->getSociety()->getId() . '.jpg');
        $fpdf->setAddHeader(PDF::WITH_HEADER);
        $fpdf->setAddFooter(PDF::WITH_FOOTER);
        $fpdf->AliasNbPages(); 
        $fpdf->setTitre('Facture');
        $fpdf->setSousTitre('un');
        $fpdf->setReference('dddd');
        $fpdf->setAdresse('TEST');
        
        $fpdf->AddPage();
        $fpdf->SetFont('Arial', 'B', 16);
        $fpdf->Cell(40, 10, 'Hello World !');

        $fpdf->executeDossier($dossier, $client, $registry, $security);
        $fpdf->AddPage();

        return new Response(
            $fpdf->Output(),
            200,
            array(
                'Content-Type' => 'application/pdf'
            )
        );
    }
}
