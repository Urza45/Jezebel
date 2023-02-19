<?php

namespace App\Controller;

use App\Services\PDF;
use App\Entity\Candidat;
use App\Entity\Categorie;
use App\Form\CandidatType;
use App\Form\ChoiceCategoriesType;
use App\Repository\CandidatRepository;
use App\Repository\CategoriechoisieRepository;
use App\Repository\CategorieRepository;
use App\Repository\NormeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * @Route("/candidat")
 */
class CandidatController extends AbstractController
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    /**
     * @Route("/", name="app_candidat_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $user = $this->security;

        if ($user->isGranted('ROLE_ULTRAADMIN')) {
            $candidats = $entityManager
                ->getRepository(Candidat::class)
                ->findAll();
        } else {
            $candidats = $entityManager
                ->getRepository(Candidat::class)
                ->findBySociety($user->getUser()->getSociety()->getId());
        }

        // $candidats = $entityManager
        //     ->getRepository(Candidat::class)
        //     ->findAll();

        return $this->render('candidat/index.html.twig', [
            'candidats' => $candidats,
        ]);
    }

    /**
     * @Route("/new", name="app_candidat_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $candidat = new Candidat();
        $form2 = $this->createForm(ChoiceCategoriesType::class, ['test' => 'test2']);

        $form = $this->createForm(CandidatType::class, $candidat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($candidat);
            $entityManager->flush();

            return $this->redirectToRoute('app_candidat_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('candidat/new.html.twig', [
            'candidat' => $candidat,
            'form' => $form,
            // 'form2' => $form2,
        ]);
    }

    /**
     * @Route("/{id}", name="app_candidat_show", methods={"GET"})
     */
    public function show(Candidat $candidat): Response
    {
        return $this->render('candidat/show.html.twig', [
            'candidat' => $candidat,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_candidat_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Candidat $candidat, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CandidatType::class, $candidat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_candidat_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('candidat/edit.html.twig', [
            'candidat' => $candidat,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_candidat_delete", methods={"POST"})
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
     * @Route("/{id}/{id_categorie}", name="app_candidat_test_pratique_result")
     * @ParamConverter("categorie", options={"id" = "id_categorie"})
     */
    public function resultsCandidatPDF(
        Candidat $candidat,
        Categorie $categorie,
        CandidatRepository $candidatRepository,
        CategorieRepository $categorieRepository,
        CategoriechoisieRepository $categoriechoisieRepository,
        NormeRepository $normeRepository
    ) {
        $user = $this->security;

        $fpdf = new PDF();
        // Paramètre du PDF
        $fpdf->SetFont('Arial');
        $fpdf->setReference('Serge Pillay');
        $fpdf->setLogo('./images/logo/' . $user->getUser()->getSociety()->getId() . '.jpg');
        $fpdf->setTitre($user->getUser()->getSociety()->getName());
        $adresse = $user->getUser()->getSociety()->getAddress()
            . ' - ' . $user->getUser()->getSociety()->getCp()
            . ' - ' . $user->getUser()->getSociety()->getTown();
        $fpdf->setAdresse($adresse);
        $fpdf->AliasNbPages();

        // Première page
        // $fpdf->AddPage();
        // $fpdf->firstPage('', '');

        // Pages suivantes
        // $fpdf->AddPage();
        // $fpdf->processDossier(
        //     $candidat->getIdDossier(),
        //     $candidat->getIdClient(),
        //     $candidatRepository
        // );

        // $fpdf->processCandidat(
        //     $candidat,
        //     $candidat->getIdDossier()->getIdNorme(),
        //     $categorieRepository,
        //     $categoriechoisieRepository
        // );

        // $fpdf->Ln(5);
        // $fpdf->SetFont('Arial', 'B', 15);
        // $fpdf->Cell(0, 10, utf8_decode('Intervenants'), 1, 0, 'C');
        // $fpdf->Ln(15);
        // /* Ligne 1 */
        // $fpdf->SetFont('Arial', '', 12);
        // $fpdf->SetTextColor(0, 0, 255);
        // $fpdf->Cell(50, 10, utf8_decode('Formateur :'), 0, 0, 'R');
        // $fpdf->SetTextColor(0, 0, 0);
        // $fpdf->Cell(30, 10, utf8_decode($candidat->getIdDossier()->getIdFormateur()->getName() . ' ' . $candidat->getIdDossier()->getIdFormateur()->getSurname()), 0, 1, 'L');
        // /* Ligne 2 */
        // $fpdf->SetTextColor(0, 0, 255);
        // $fpdf->Cell(50, 10, utf8_decode('Testeur :'), 0, 0, 'R');
        // $fpdf->SetTextColor(0, 0, 0);
        // $fpdf->Cell(30, 10, utf8_decode($candidat->getIdDossier()->getIdTesteur()->getName() . ' ' . $candidat->getIdDossier()->getIdTesteur()->getSurname()), 0, 1, 'L');

        // $fpdf->AddPage();
        // $fpdf->processResultat(
        //     $candidat,
        //     $candidat->getIdDossier(),
        //     $candidatRepository,
        //     $categorieRepository,
        //     $categoriechoisieRepository
        // );

        // $fpdf->Cell(50, 10, utf8_decode($categorie->getLabel()), 1, 0, 'C');
        // $fpdf = $candidatRepository->resultats_categoriePDF($fpdf, $candidat->getId(), $categorie->getId());

        // $listChosenCategory = $categoriechoisieRepository->findByIdCandidat($candidat->getId());
        // foreach ($listChosenCategory as $categorieChoisie) {
        //     // $this->cell(12, 10, $categorie->getLabelCourt(), 1, 0, 'C');
        //     $listIdCategorieChoisie[] = $categorieChoisie->getIdCategory()->getId();
        // }
        // // $manager3 = $this->managers->getManagerOf('Norme');
        // // $listCategory = $manager3->getCategory($dossier['id_norme']);
        // $listCategory = $categorieRepository->findByIdNorme($candidat->getIdDossier()->getIdNorme()->getId());
        // foreach ($listCategory as $categorie) {
        //     // $fpdf->cell(12, 10, $categorie->getLabelCourt(), 1, 0, 'C');
        //     $listIdCategorie[] = $categorie->getId();
        // }
        // /* RESULTATS */
        // foreach ($listIdCategorie as $value) {
        //     if (in_array($value, $listIdCategorieChoisie)) {
        //         $fpdf->Cell(50, 10, utf8_decode($categorieRepository->findOneById($value)->getLabel()), 1, 0, 'C');
        //         $fpdf = $candidatRepository->resultats_categoriePDF($fpdf, $candidat->getId(), $value);
        //     }
        // }


        // $fpdf = $candidatRepository->resultats_categoriePDF($fpdf, $candidat->getId(), $categorie->getId());
        $fpdf->setAddHeader(PDF::WITH_HEADER);
        $fpdf->setAddFooter(PDF::WITH_FOOTER);
        $fpdf->AddPage();
            
        $fpdf->SetFont('Arial','B',15);
        $fpdf->Cell(0,10, utf8_decode($candidat->getIdDossier()->getIdNorme()->getLabel().' - '.$categorie->getLabel()),'LTR',0,'C'); $fpdf->Ln(5);
        $fpdf->SetFont('Arial','',12);
        $fpdf->Cell(0,10,utf8_decode($candidat->getIdDossier()->getIdNorme()->getComments()),'LBR',0,'C'); $fpdf->Ln(15);
        $fpdf->setReference('CFP78-TP-'.$categorie->getLabelCourt());



        $note1 = $candidatRepository->loadNotes1($candidat->getId(), $categorie->getId());
        $note2 = $candidatRepository->loadNotes2($candidat->getId(), $categorie->getId());
        
        $fpdf = $normeRepository->getQuestionnairePDF($fpdf, $candidat->getIdDossier()->getIdNorme()->getId(), $categorie->getId(), $note1, $note2);

        return new Response($fpdf->Output(), 200, array(
            'Content-Type' => 'application/pdf'
        ));
    }
}
