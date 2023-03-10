<?php

namespace App\Controller\Frontend;

use App\Services\PDF;
use App\Entity\Candidat;
use App\Entity\Categorie;
use App\Entity\Quiz;
use App\Form\CandidatType;
use App\Form\Search\SearchCandidatNameSurnameType;
use App\Repository\CandidatRepository;
use App\Repository\NormeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * @Route("/candidat")
 */
class CandidatController extends AbstractController
{
    /**
     * index
     *
     * @param Request            $request
     * @param CandidatRepository $candidatRepository
     * 
     * @Route("/", name="app_candidat_index", methods={"GET","POST"})
     * 
     * @return Response
     */
    public function index(Request $request, CandidatRepository $candidatRepository): Response
    {
        $form = $this->createForm(SearchCandidatNameSurnameType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $nom = $form->get('name')->getData();
            $prenom = $form->get('surname')->getData();
            $candidats = $candidatRepository->SearchByNameSurname($nom, $prenom);
        } else {

            if ($this->isGranted('ROLE_ULTRAADMIN')) {
                $candidats = $candidatRepository->findAll();
            } else {
                $candidats = $candidatRepository->findBySociety($this->getUser()->getSociety()->getId());
            }
        }

        return $this->render(
            'candidat/index.html.twig',
            [
                'candidats' => $candidats,
                'form' => $form->createView()
            ]
        );
    }

    /**
     * new
     *
     * @param  Request                $request
     * @param  EntityManagerInterface $entityManager
     * 
     * @Route("/new", name="app_candidat_new", methods={"GET", "POST"})
     * 
     * @return Response
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $candidat = new Candidat();

        $form = $this->createForm(CandidatType::class, $candidat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($candidat);
            $entityManager->flush();

            return $this->redirectToRoute('app_candidat_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm(
            'candidat/new.html.twig',
            [
                'candidat' => $candidat,
                'form' => $form,
            ]
        );
    }

    /**
     * show
     *
     * @param  mixed $candidat
     * 
     * @Route("/{id}", name="app_candidat_show", methods={"GET"})
     * 
     * @return Response
     */
    public function show(Candidat $candidat): Response
    {
        return $this->render(
            'candidat/show.html.twig',
            [
                'candidat' => $candidat,
            ]
        );
    }

    /**
     * edit
     *
     * @param  Request                $request
     * @param  Candidat               $candidat
     * @param  EntityManagerInterface $entityManager
     * 
     * @Route("/{id}/edit", name="app_candidat_edit", methods={"GET", "POST"})
     * 
     * @return Response
     */
    public function edit(Request $request, Candidat $candidat, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CandidatType::class, $candidat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_candidat_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm(
            'candidat/edit.html.twig',
            [
                'candidat' => $candidat,
                'form' => $form,
            ]
        );
    }

    /**
     * delete
     *
     * @param  Request                $request
     * @param  Candidat               $candidat
     * @param  EntityManagerInterface $entityManager
     * 
     * @Route("/{id}", name="app_candidat_delete", methods={"POST"})
     * 
     * @return Response
     */
    public function delete(Request $request, Candidat $candidat, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $candidat->getId(), $request->request->get('_token'))) {
            $entityManager->remove($candidat);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_candidat_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * resultsCandidatPDF
     *
     * @param  Candidat           $candidat
     * @param  Categorie          $categorie
     * @param  CandidatRepository $candidatRepository
     * @param  NormeRepository    $normeRepository
     * 
     * @Route("/rp/{id}/{id_categorie}", name="app_candidat_test_pratique_result")
     * @ParamConverter("categorie",   options={"id" = "id_categorie"})
     * 
     * @return void
     */
    public function resultsCandidatPDF(
        Candidat $candidat,
        Categorie $categorie,
        CandidatRepository $candidatRepository,
        NormeRepository $normeRepository
    ) {
        $fpdf = new PDF();
        // Paramètre du PDF
        $fpdf->SetFont('Arial');
        $fpdf->setReference('');
        $fpdf->setLogo('./images/logo/' . $this->getUser()->getSociety()->getId() . '.jpg');
        $fpdf->setTitre($this->getUser()->getSociety()->getName());
        $adresse = $this->getUser()->getSociety()->getAddress()
            . ' - ' . $this->getUser()->getSociety()->getCp()
            . ' - ' . $this->getUser()->getSociety()->getTown();
        $fpdf->setAdresse($adresse);
        $fpdf->AliasNbPages();
        $fpdf->setAddHeader(PDF::WITH_HEADER);
        $fpdf->setAddFooter(PDF::WITH_FOOTER);
        $fpdf->AddPage();

        $fpdf->SetFont('Arial', 'B', 15);
        $fpdf->Cell(0, 10, utf8_decode($candidat->getIdDossier()->getIdNorme()->getLabel() . ' - ' . $categorie->getLabel()), 'LTR', 0, 'C');
        $fpdf->Ln(5);
        $fpdf->SetFont('Arial', '', 12);
        $fpdf->Cell(0, 10, utf8_decode($candidat->getIdDossier()->getIdNorme()->getComments()), 'LBR', 0, 'C');
        $fpdf->Ln(15);
        $fpdf->setReference('CFP78-TP-' . $categorie->getLabelCourt());

        $note1 = $candidatRepository->loadNotes1($candidat->getId(), $categorie->getId());
        $note2 = $candidatRepository->loadNotes2($candidat->getId(), $categorie->getId());

        $fpdf = $normeRepository->getQuestionnairePDF($fpdf, $candidat->getIdDossier()->getIdNorme()->getId(), $categorie->getId(), $note1, $note2);

        return new Response(
            $fpdf->Output(),
            200,
            array(
                'Content-Type' => 'application/pdf'
            )
        );
    }

    /**
     * resultsTheoryPDF
     *
     * @param  Candidat           $candidat
     * @param  Quiz               $quiz
     * @param  CandidatRepository $candidatRepository
     * @param  NormeRepository    $normeRepository
     * @param  Quiz                
     * 
     * @Route("/rt/{id}/{id_quiz}", name="app_candidat_test_theo_result")
     * @ParamConverter("quiz", options={"id" = "id_quiz"})
     * 
     * @return void
     */
    public function resultsTheoryPDF(
        Candidat $candidat,
        Quiz $quiz,
        CandidatRepository $candidatRepository,
        NormeRepository $normeRepository
    ) {
        $fpdf = new PDF();
        $societe = $this->getUser()->getSociety();
        // Paramètre du PDF
        $fpdf->SetFont('Arial');
        $fpdf->setReference('');
        $fpdf->setLogo('./images/logo/' . $societe->getId() . '.jpg');
        $fpdf->setTitre($societe->getName());
        $adresse = $societe->getAddress()
            . ' - ' . $societe->getCp()
            . ' - ' . $societe->getTown();
        $fpdf->setAdresse($adresse);
        $fpdf->AliasNbPages();
        $fpdf->setAddHeader(PDF::WITH_HEADER);
        $fpdf->setAddFooter(PDF::WITH_FOOTER);
        $fpdf->AddPage();

        $userQuizResults = $candidat->getUserQuizResults();
        
        foreach($userQuizResults as $userQuizResult) {
            dump('userQuizResult : ' . $userQuizResult->getNorme()->getLabel());
            $answers = $userQuizResult->getUserQuizAnswers();
            foreach($answers as $answer) {
                dump($answer);
            }
        }

        dump($candidat->getUserQuizResults());
        dd($quiz->getThemeTheoriques());

        return new Response(
            $fpdf->Output(),
            200,
            array(
                'Content-Type' => 'application/pdf'
            )
        );
    }
}
