<?php

namespace App\Repository;

use App\Entity\Norme;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Norme>
 *
 * @method Norme|null find($id, $lockMode = null, $lockVersion = null)
 * @method Norme|null findOneBy(array $criteria, array $orderBy = null)
 * @method Norme[]    findAll()
 * @method Norme[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NormeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Norme::class);
    }

    public function add(Norme $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Norme $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return Norme[] Returns an array of Norme objects
     */
    public function findById($value): array
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.id = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }

    //    public function findOneBySomeField($value): ?Test
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }



    public function getQuestionnaire($id_norme, $id_categorie, $id_candidat, array $tabNote1 = null, array $tabNote2 = null)
    {
        $conn = $this->getEntityManager()->getConnection();
        $content = '';
        // Récupération des thèmes
        $requete = $conn->prepare('SELECT id, id_categorie, ordre, label, pts1, pts2 FROM theme WHERE id_categorie= :id_categorie');
        $requete->bindValue(':id_categorie', (int) $id_categorie);
        $resultSet = $requete->execute();

        $listeTheme = $resultSet->fetchAll();
        $style = 'row-a';
        $increment = 0; // Nombre de questions
        //$increNote1 = 0;
        //$increNote2 = 0;
        $content .= '<table>';
        foreach ($listeTheme as $theme) {
            // Thème
            $content .= '<tr class="' . $style . '">' . "\n";
            $content .= '<td><h2>' . $theme['label'] . '</h2><br/>(' . $theme['pts1'] . ' pts';
            if ($theme['pts2'] > 0) {
                $content .= ' / ' . $theme['pts2'] . ' pts';
            }
            $content .= ')</td>' . "\n";

            // Récupération des points d'évaluation
            $requete2 = $conn->prepare('SELECT id, id_theme, point, label FROM consigne WHERE id_theme= :id_theme');
            $requete2->bindValue(':id_theme', (int) $theme['id']);
            $resultSet2 = $requete2->execute();

            $listeConsigne = $resultSet2->fetchAll();

            $content .= '<td><table width="80%">' . "\n";
            foreach ($listeConsigne as $consigne) {
                $content .= '<tr class="' . $style . '"><td class="align-left"><B>Point ' . $consigne['point'] . ' ';
                if ($consigne['label'] != '') {
                    $content .= '- ';
                }
                $content .= $consigne['label'] . '</B>';
                // Récupération des critères
                $requete3 = $conn->prepare('SELECT id, id_consigne, label, ptse1, ptse2 FROM critere WHERE id_consigne= :id_consigne');
                $requete3->bindValue(':id_consigne', (int) $consigne['id']);
                $resultSet3 = $requete3->execute();

                $listeCritere = $resultSet3->fetchAll();

                foreach ($listeCritere as $critere) {
                    if ($consigne['label'] != '') {
                        $content .= '<br/>' . "\n";
                    }
                    $content .= '<li>';
                    if ($critere['ptse1'] > 0) {
                        $content .= '<input type="number" name="note_1[' . $increment . ']" value="';
                        if ($tabNote1 !== null) {
                            $content .= $tabNote1[$increment];
                        }
                        $content .= '" size="3" min="0" max="' . $critere['ptse1'] . '" required /> / ' . $critere['ptse1'] . "\n";
                        $content .= ' - ';
                    } else {
                        $content .= '<input type="number" name="note_1[' . $increment . ']" value="" size="1" hidden />/';
                    }
                    // $content .= ' - ';
                    if ($critere['ptse2'] > 0) {
                        $content .= '<input type="number" name="note_2[' . $increment . ']" value="';
                        if ($tabNote2 !== null) {
                            $content .= $tabNote2[$increment];
                        }
                        $content .= '" size="3" min="0" max="' . $critere['ptse2'] . '" required />' . $critere['ptse2'] . "\n";
                        $content .= ' - ';
                    } else {
                        $content .= '<input type="number" name="note_2[' . $increment . ']" value="" size="1" hidden />';
                    }
                    $content .= ' ' . str_replace("'", "&acute;", $critere['label']) . "\n";
                    $content .= '<input type="hidden" name="critere_id[' . $increment . ']" value="' . $critere['id'] . '"/>' . "\n";
                    $increment++;
                }
                $content .= '</td></tr>' . "\n";
            }
            $content .= '</table></td>' . "\n";

            if ($style == 'row-a') {
                $style = 'row-b';
            } else {
                $style = 'row-a';
            }
            $content .= '</tr>' . "\n";
            $content .= '<tr><td>'
                . '<input type="hidden" name="id_norme" value="' . $id_norme . '"/>'
                . '<input type="hidden" name="id_categorie" value="' . $id_categorie . '"/>'
                . '<input type="hidden" name="id_candidat" value="' . $id_candidat . '"/>'
                . '<input type="hidden" name="increment" value="' . $increment . '"/>'
                . '</td></tr>' . "\n";
        }
        $content .= '</table>';
        return utf8_encode($content);
    }

    public function getQuestionnairePDF($pdf, $id_norme, $id_categorie, array $tabNote1 = null, array $tabNote2 = null)
    {
        $conn = $this->getEntityManager()->getConnection();
        $requete = $conn->prepare('SELECT id, id_categorie, ordre, label, pts1, pts2 FROM theme WHERE id_categorie= :id_categorie');
        $requete->bindValue(':id_categorie', (int) $id_categorie);
        $listeTheme = $requete->execute()->fetchAll();
        $style = 'row-a';
        $increment = 0; // Nombre de questions
        $pdf->Rect(10, 60, 190, 220);
        $pdf->Rect(10, 60, 50, 220); //$pdf->GetX().' '.$pdf->GetY().' '.$pdf->GetPageWidth().' '.$pdf->GetPageHeight()
        $pdf->Cell(50, 10, utf8_decode('Thèmes'), '1', 0, 'C');
        $pdf->Cell(0, 10, utf8_decode('Questions'), '1', 0, 'C');
        $pdf->Ln(11);
        $Y = $pdf->GetY();

        foreach ($listeTheme as $theme) {
            // Thème
            $pdf->SetX(10);
            $pdf->SetY($Y);

            $pdf->Line(10, $Y - 1, 200, $Y - 1);

            $chaine = utf8_decode($theme['label']) . "\n" . '(' . $theme['pts1'] . ' pts';
            if ($theme['pts2'] > 0) {
                $chaine .= ' / ' . $theme['pts2'] . ' pts';
            }
            $chaine .= ')';
            $pdf->Multicell(50, 5, $chaine, 0, 'L');
            // Récupération des points d'évaluation
            $requete2 = $conn->prepare('SELECT id, id_theme, point, label FROM consigne WHERE id_theme= :id_theme');
            $requete2->bindValue(':id_theme', (int) $theme['id']);
            $pdf->SetY($Y);
            $listeConsigne = $requete2->execute()->fetchAll();
            foreach ($listeConsigne as $consigne) {
                $pdf->SetX(61);
                $pdf->SetFont('Arial', 'B', 12);
                $chaine = 'Point ' . $consigne['point'];
                if ($consigne['label'] != '') {
                    $chaine .= ' - ';
                }
                $chaine .= $consigne['label'];
                $pdf->Multicell(0, 5, utf8_decode($chaine), 0, 'L');
                $pdf->Ln(1);
                $Y = $pdf->GetY();
                // Récupération des critères
                $requete3 = $conn->prepare('SELECT id, id_consigne, label, ptse1, ptse2 FROM critere WHERE id_consigne= :id_consigne');
                $requete3->bindValue(':id_consigne', (int) $consigne['id']);

                $listeCritere = $requete3->execute()->fetchAll();

                foreach ($listeCritere as $critere) {
                    if ($Y > 263) {
                        $pdf->AddPage();
                        $pdf->Rect(10, 40, 190, 240);
                        $pdf->Rect(10, 40, 50, 240); //$pdf->GetX().' '.$pdf->GetY().' '.$pdf->GetPageWidth().' '.$pdf->GetPageHeight()
                        $pdf->Cell(50, 10, utf8_decode('Thèmes'), '1', 0, 'C');
                        $pdf->Cell(0, 10, utf8_decode('Questions'), '1', 0, 'C');
                        $pdf->Ln(11);
                        $Y = $pdf->GetY();
                    }

                    $pdf->SetX(61);
                    $pdf->SetFont('Arial', '', 12);
                    $chaine = chr(149);
                    if ($critere['ptse1'] > 0) {
                        if ($tabNote1 !== null) {
                            $chaine .= $tabNote1[$increment];
                        } else {
                            $chaine .= '___';
                        }
                        $chaine .= ' / ' . $critere['ptse1'];
                    } else {
                        $chaine .= 'XXX';
                    }
                    $chaine .= ' - ';
                    if ($critere['ptse2'] > 0) {
                        if ($tabNote2 !== null) {
                            $chaine .= $tabNote2[$increment];
                        } else {
                            $chaine .= '___';
                        }
                        $chaine .= ' / ' . $critere['ptse2'];
                    } else {
                        $chaine .= 'XXX';
                    }
                    $chaine .= ' ' . utf8_decode($critere['label']);
                    $pdf->Multicell(0, 5, $chaine, 0, 'L');
                    $pdf->Ln(1);
                    $Y = $pdf->GetY();

                    $increment++;
                }
            }
        }
        return $pdf;
    }
}
