<?php

/*
 * Serge Pillay<serge.pillay@orange.fr>
 */

namespace App\Services;

use FPDF;
use App\Entity\Norme;
use App\Entity\Client;
use App\Entity\Dossier;
use App\Entity\Candidat;
use App\Entity\Categorie;
use App\Repository\CandidatRepository;
use App\Repository\CategoriechoisieRepository;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Description of PDF
 *
 * @author Serge
 */
class PDF extends FPDF
{
    protected $titre = '';
    protected $sousTitre = '';
    protected $reference = '';
    protected $logo = '';
    protected $adresse = '';

    public function setTitre($titre)
    {
        $this->titre = $titre;
    }

    public function setReference($reference)
    {
        $this->reference = $reference;
    }

    public function setLogo($logo)
    {
        $this->logo = $logo;
    }

    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;
    }

    public function setSousTitre($sousTitre)
    {
        $this->sousTitre = $sousTitre;
    }
    // En-tête
    function Header()
    {
        if ($this->PageNo() == 1) {
            //Première page
        } else {
            // Logo
            $this->Image($this->logo, 10, 6, 30);
            // Police Arial gras 15
            $this->SetFont('Arial', 'B', 12);
            // Décalage à droite
            $this->Cell(100);
            // Titre
            $this->Cell(30, 10, $this->titre, 0, 0, 'C');
            $this->SetFont('Arial', '', 12);
            $this->Ln(5);
            $this->Cell(100);
            $this->Cell(30, 10, utf8_decode($this->sousTitre), 0, 0, 'C');
            // Saut de ligne
            $this->Ln(5);
            $this->Cell(100);
            $this->Cell(30, 10, utf8_decode($this->adresse), 0, 0, 'C');
            $this->Ln(20);
        }
    }

    // Pied de page
    function Footer()
    {
        if ($this->PageNo() == 1) {
            //Première page
        } else {
            // Positionnement à 1,5 cm du bas
            $this->SetY(-15);
            // Police Arial italique 8
            $this->SetFont('Arial', 'I', 8);
            // Numéro de page
            $chaine = '';
            if ($this->reference != '') {
                $chaine = 'Document Réf : ' . $this->reference;
            }
            $this->Cell(150, 10, utf8_decode($chaine), 1, 0, 'C');
            $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 1, 0, 'R');
        }
    }

    public function firstPage($titre, $adresse)
    {
        // Logo
        $this->Image($this->logo, 10, 6);
        $this->SetY(200);
        // Police Arial gras 15
        $this->SetFont('Arial', 'B', 12);
        // Titre
        $this->Cell(0, 10, $this->titre, 0, 0, 'C');
        $this->SetFont('Arial', '', 12);
        $this->Ln(5);
        $this->Cell(0, 10, utf8_decode($this->sousTitre), 0, 0, 'C');
        // Saut de ligne
        $this->Ln(5);
        $this->Cell(0, 10, $this->adresse, 0, 0, 'C');
        $this->Ln(20);
        // return $pdf;
    }

    public function processDossier(Dossier $dossier, Client $client, CandidatRepository $candidatRepository)
    {
        $this->SetFont('Arial', 'B', 15);
        $this->Cell(0, 10, utf8_decode($dossier->getNumDossier() . ' - ' . $client->getNomClient() . ' - Du ' . date('d/m/Y', $dossier->getDateDebut()->getTimestamp()) . ' au ' . date('d/m/Y', $dossier->getDateFin()->getTimestamp()) . ' - ' . $dossier->getIdNorme()->getLabel()), 1, 0, 'C');
        $this->Ln(15);
        $this->SetFont('Arial', '', 12);
        /* Ligne 1 */
        $this->SetTextColor(0, 0, 255);
        $this->Cell(50, 10, utf8_decode('Numéro du dossier :'), 0, 0, 'R');
        $this->SetTextColor(0, 0, 0);
        $this->Cell(30, 10, $dossier->getNumDossier(), 0, 0, 'L');
        $this->SetTextColor(0, 0, 255);
        $this->Cell(50, 10, utf8_decode('Numéro du facture :'), 0, 0, 'R');
        $this->SetTextColor(0, 0, 0);
        $this->Cell(30, 10, $dossier->getNumFacture(), 0, 1, 'L');
        // /* Ligne 2 */
        $this->SetTextColor(0, 0, 255);
        $this->Cell(50, 10, utf8_decode('Dates - Du :'), 0, 0, 'R');
        $this->SetTextColor(0, 0, 0);
        $this->Cell(30, 10, date('d/m/Y', $dossier->getDateDebut()->getTimestamp()), 0, 0, 'L');
        $this->SetTextColor(0, 0, 255);
        $this->Cell(50, 10, utf8_decode('au :'), 0, 0, 'R');
        $this->SetTextColor(0, 0, 0);
        $this->Cell(30, 10, date('d/m/Y', strtotime($dossier->getDateFin()->getTimestamp())), 0, 1, 'L');
        // /* Ligne 3 */
        $this->SetTextColor(0, 0, 255);
        $this->Cell(50, 10, utf8_decode('Nom du client :'), 0, 0, 'R');
        $this->SetTextColor(0, 0, 0);
        $this->Cell(0, 10, $client->getNomClient(), 0, 1, 'L');
        // /* Ligne 4 */
        $this->SetTextColor(0, 0, 255);
        $this->Cell(50, 10, utf8_decode('Intitulé de l\'action :'), 0, 0, 'R');
        $this->SetTextColor(0, 0, 0);
        if ($dossier->getType() == 'CACES') {
            $chaine = $dossier->getType() . chr(174);
        } else {
            $chaine = 'Autorisation de conduite';
        }
        $this->Cell(30, 10, $chaine, 0, 0, 'L');
        $this->SetTextColor(0, 0, 255);
        $this->Cell(50, 10, utf8_decode('Catégorie :'), 0, 0, 'R');
        $this->SetTextColor(0, 0, 0);
        $this->Cell(30, 10, $dossier->getIdNorme()->getLabel(), 0, 1, 'L');
        // /* Ligne 5 */
        $this->SetTextColor(0, 0, 255);
        $this->Cell(50, 10, utf8_decode('Adresse intervention :'), 0, 0, 'R');
        $this->SetTextColor(0, 0, 0);
        $chaine = $dossier->getAdresseIntervention() . ' ' . $dossier->getCpIntervention() . ' ' . $dossier->getVilleIntervention();
        $this->Cell(0, 10, utf8_decode($chaine), 0, 1, 'L');
        // return $pdf;
    }

    public function processCandidat(Candidat $candidat, Norme $norme, CategorieRepository $categorieRepository, CategoriechoisieRepository $categoriechoisieRepository)
    {
        $this->SetFont('Arial', 'B', 15);
        $this->Cell(0, 10, 'Candidat', 1, 0, 'C');
        $this->Ln(15);
        $this->SetFont('Arial', 'B', 12);
        $this->SetTextColor(0, 0, 255);
        $this->cell(40, 10, 'Nom', 1, 0, 'C');
        $this->cell(40, 10, utf8_decode('Prénom'), 1, 0, 'C');
        $this->cell(40, 10, 'Date de naissance', 1, 0, 'C');
        // $listeCategorie = $this->managers->getManagerOf('Norme')->getCategory($norme['id']);
        $listeCategorie = $categorieRepository->findByIdNorme($norme->getId());
        foreach ($listeCategorie as $categorie) {
            $this->cell(12, 10, $categorie->getLabelCourt(), 1, 0, 'C');
            $listIdCategorie[] = $categorie->getId();
        }
        $this->ln();
        $this->SetFont('Arial', '', 12);
        $this->SetTextColor(0, 0, 0);
        // foreach ($candidats as $candidat) {
        $this->cell(40, 10, $candidat->getNomCandidat(), 1, 0, 'L');
        $this->cell(40, 10, $candidat->getPrenomCandidat(), 1, 0, 'L');
        $this->cell(40, 10, date('d/m/Y', $candidat->getDateNaissance()->getTimestamp()), 1, 0, 'L');

        // $listeCategorieChoisies = $this->managers->getManagerOf('Candidat')->getCategoriesChoisies($candidat['id']);
        $listeCategorieChoisies = $categoriechoisieRepository->findByIdCandidat($candidat->getId());
        foreach ($listeCategorieChoisies as $categorieChoisie) {
            // $this->cell(12, 10, $categorie->getLabelCourt(), 1, 0, 'C');
            $listIdCategorieChoisie[] = $categorieChoisie->getIdCategory()->getId();
        }
        // $listeCategorieChoisies = $candidat->getCate
        foreach ($listIdCategorie as $value) {
            if (in_array($value, $listIdCategorieChoisie)) {
                $this->cell(12, 10, 'X', 1, 0, 'C');
            } else {
                $this->cell(12, 10, ' ', 1, 0, 'C');
            }
        }
        $this->Ln();
        // }
        // return $pdf;
    }



    public function executeDossier(Dossier $dossier, Client $client, CandidatRepository $candidatRepository)
    {
        $id_dossier = $dossier->getId();

        $pdf = new PDF();

        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf = $this->processGarde($pdf);
        $pdf->AddPage();

        $dossier = $this->managers->getManagerOf('Dossier')->getUnique($id_dossier);
        $client =  $this->managers->getManagerOf('Client')->getUnique($dossier['id_client']);
        $candidats = $this->managers->getManagerOf('Candidat')->getList($dossier['id_client'], $id_dossier);
        $norme = $this->managers->getManagerOf('Norme')->getUnique($dossier['id_norme']);

        $this->processDossier($pdf, $dossier, $client, $norme);
        $this->processCandidat($pdf, $candidats, $norme);
        $testeur = $this->managers->getManagerOf('UserEntity')->getUnique($dossier['id_testeur']);
        $formateur = $this->managers->getManagerOf('UserEntity')->getUnique($dossier['id_formateur']);
        $pdf->Ln(5);
        $pdf->SetFont('Arial', 'B', 15);
        $pdf->Cell(0, 10, utf8_decode('Intervenants'), 1, 0, 'C');
        $pdf->Ln(15);
        /* Ligne 1 */
        $pdf->SetFont('Arial', '', 12);
        $pdf->SetTextColor(0, 0, 255);
        $pdf->Cell(50, 10, utf8_decode('Formateur :'), 0, 0, 'R');
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(30, 10, utf8_decode($formateur['_name'] . ' ' . $formateur['surname']), 0, 1, 'L');
        /* Ligne 2 */
        $pdf->SetTextColor(0, 0, 255);
        $pdf->Cell(50, 10, utf8_decode('Testeur :'), 0, 0, 'R');
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(30, 10, utf8_decode($testeur['_name'] . ' ' . $testeur['surname']), 0, 1, 'L');
        foreach ($candidats as $candidat) {
            $managerCandidat = $this->managers->getManagerOf('Candidat');
            $pdf->AddPage();
            $this->processResultat($pdf, $candidat, $dossier);
            $listeCategorieChoisies = $managerCandidat->getCategoriesChoisies($candidat['id']);
            foreach ($listeCategorieChoisies as $value) {
                $pdf->AddPage();
                $note1 = $managerCandidat->loadNotes1($candidat['id'], $value);
                $note2 = $managerCandidat->loadNotes2($candidat['id'], $value);
                $this->processFormulaire($pdf, $norme['id'], $value, $note1, $note2);
            }
        }
        $pdf->Output('I', 'DoC.pdf', true);
    }
}
