<?php

/*
 * Serge Pillay<serge.pillay@orange.fr>
 */

namespace App\Services;

use FPDF;

/**
 * Description of PDF
 *
 * @author Serge
 */
class PDF extends FPDF
{
    // En-tête
    function Header()
    {
        // if($this->PageNo()==1)
        // {
        //     //Première page
        // }
        // else
        // {
            // Logo
            $this->Image('./images/logo.png',10,6,30);
            // Police Arial gras 15
            $this->SetFont('Arial','B',12);
            // Décalage à droite
            $this->Cell(100);
            // Titre
            $this->Cell(30,10,'CENTRE DE FORMATION PROFESSIONNELLE 78',0,0,'C');
            $this->SetFont('Arial','',12);
            $this->Ln(5);
            $this->Cell(100);$this->Cell(30,10, utf8_decode('Siége social : CFP ECQUEVILLY'),0,0,'C');
            // Saut de ligne
            $this->Ln(5);
            $this->Cell(100);$this->Cell(30,10,' 5 rue des Fontenelles 78920 ECQUEVILLY',0,0,'C');
            $this->Ln(20);
        // }
        
        
    }

    // Pied de page
    function Footer()
    {
        // if($this->PageNo()==1)
        // {
        //     //Première page
        // }
        // else
        // {
            // Positionnement à 1,5 cm du bas
            $this->SetY(-15);
            // Police Arial italique 8
            $this->SetFont('Arial','I',8);
            // Numéro de page
            $chaine = '';
            // if ($this->reference != '') {
            //     $chaine = 'Document Réf : '.$this->reference();
            // }
            $this->Cell(150, 10, utf8_decode($chaine),1,0,'C');
            $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',1,0,'R');
        // }
    }
}
