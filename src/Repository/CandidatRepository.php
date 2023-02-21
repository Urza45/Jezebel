<?php

namespace App\Repository;

use App\Entity\Candidat;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Candidat>
 *
 * @method Candidat|null find($id, $lockMode = null, $lockVersion = null)
 * @method Candidat|null findOneBy(array $criteria, array $orderBy = null)
 * @method Candidat[]    findAll()
 * @method Candidat[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CandidatRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Candidat::class);
    }

    public function add(Candidat $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Candidat $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    //    /**
    //     * @return Candidat[] Returns an array of Candidat objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Candidat
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    public function saveNotes($id_candidat, $id_categorie, $increment, array $tabCriteres, array $tabNotes1, array $tabNotes2 = null)
    {
        $conn = $this->getEntityManager()->getConnection();
        for ($i = 0; $i < $increment; $i++) {
            /* Vérification de l'existance d'une note sur le critère en cours */

            $sql = 'INSERT INTO notecritere SET '
                . 'id_candidat = :id_candidat, '
                . 'id_categorie = :id_categorie, '
                . 'id_critere = :id_critere, '
                . 'note1 = :note1, '
                . 'note2 = :note2 ';

            $nbLigne = $conn->query('SELECT COUNT(*) FROM notecritere WHERE id_candidat=' . $id_candidat . ' AND id_critere=' . $tabCriteres[$i])->fetchFirstColumn();
            $nb = (int) $nbLigne[0];
            if ($nb > 0) {
                $sql = 'UPDATE notecritere SET '
                    . 'id_categorie = :id_categorie, '
                    . 'note1 = :note1, '
                    . 'note2 = :note2 '
                    . 'WHERE id_candidat = :id_candidat AND id_critere = :id_critere';
            }
            $requete = $conn->prepare($sql);
            $requete->bindValue(':id_candidat', (int) $id_candidat, \PDO::PARAM_INT);
            $requete->bindValue(':id_categorie', (int) $id_categorie, \PDO::PARAM_INT);
            $requete->bindValue(':id_critere', (int) $tabCriteres[$i], \PDO::PARAM_INT);
            if ($tabNotes1[$i] != null) {
                $requete->bindValue(':note1', $tabNotes1[$i], \PDO::PARAM_INT);
            } else {
                $requete->bindValue(':note1', null);
            }
            if ($tabNotes2[$i] != null) {
                $requete->bindValue(':note2', $tabNotes2[$i], \PDO::PARAM_INT);
            } else {
                $requete->bindValue(':note2', null);
            }
            $requete->execute();
        }
        // Sauvegarde de la date
        $date = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d"), date("Y")));
        $sql = 'UPDATE categoriechoisie SET '
            . 'date_pratique = :date, '
            . 'result = :result '
            . 'WHERE id_candidat = :id_candidat AND id_category = :id_categorie';
        $requete2 = $conn->prepare($sql);
        $requete2->bindValue(':id_candidat', (int) $id_candidat, \PDO::PARAM_INT);
        $requete2->bindValue(':id_categorie', (int) $id_categorie, \PDO::PARAM_INT);
        $requete2->bindValue(':date', $date, \PDO::PARAM_STR);
        $requete2->bindValue(':result', $this->resultatCategory($id_candidat, $id_categorie));
        $requete2->execute();
    }

    public function loadNotes1($id_candidat, $id_categorie)
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT note1 FROM notecritere WHERE id_candidat=' . $id_candidat . ' AND id_categorie=' . $id_categorie . ' ORDER BY id_critere';
        $requete = $conn->query($sql);
        $Note1 = $requete->fetchall();
        $listNote1 = null;
        foreach ($Note1 as $key => $value) {
            $listNote1[] = $value['note1'];
        }
        return $listNote1;
    }

    public function loadNotes2($id_candidat, $id_categorie)
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT note2 FROM notecritere WHERE id_candidat=' . $id_candidat . ' AND id_categorie=' . $id_categorie . ' ORDER BY id_critere';
        $requete = $conn->query($sql);
        $Note2 = $requete->fetchall();
        $listNote2 = null;
        foreach ($Note2 as $key => $value) {
            $listNote2[] = $value['note2'];
        }
        return $listNote2;
    }

    public function resultats_categorie($id_candidat, $id_categorie)
    {
        $conn = $this->getEntityManager()->getConnection();
        $condition = 'RECU';
        /* Note globale */
        $stmt = $conn->prepare('CALL noteglobal(' . $id_candidat . ',' . $id_categorie . ')');
        $return_value = $stmt->execute()->fetchall();
        $content = '<table><tr><th>Note Véhicule 1</th><th>Note Véhicule 2</th></tr>';
        $content .= '<tr>';
        foreach ($return_value as $value) {
            if (($value['SUM(note1)'] < 70) && ($value['SUM(note1)'] != null)) {
                $style = 'text-danger';
                $condition = 'ECHEC';
            } else {
                $style = 'text-success';
            }
            $content .= '<td><p class="' . $style . '">' . $value['SUM(note1)'] . '</p></td>';
            if (($value['SUM(note2)'] < 70) && ($value['SUM(note2)'] != null)) {
                $style = 'text-danger';
                $condition = 'ECHEC';
            } else {
                $style = 'text-success';
            }
            $content .= '<td><p class="' . $style . '">' . $value['SUM(note2)'] . '</p></td>';
        }
        $content .= '</tr></table>';
        /* Note par theme */
        $stmt = $conn->prepare('CALL notetheme(' . $id_candidat . ',' . $id_categorie . ')');
        $return_value = $stmt->execute()->fetchAll();
        $content .= '<table><tr><th>Thème</th><th>Véhicule 1</th><th>Véhicule 2</th></tr>';
        foreach ($return_value as $key => $value) {
            $content .= '<tr>';
            $content .= '<td><P>' . utf8_encode($value['label']) . '</p></td>';
            if (($value['note1'] != null) && ($value['pts1'] != null)) {
                if ($value['note1'] >= ($value['pts1'] / 2)) {
                    $style = 'text-success';
                } else {
                    $style = 'text-danger';
                    $condition = 'AJOURNE3';
                }
                $content .= '<td><p class="' . $style . '">' . $value['note1'] . '/' . $value['pts1'] . '</p></td>';
            } else {
                $content .= '<td></td>';
            }
            if (($value['note2'] != null) && ($value['pts2'] != null)) {
                if ($value['note2'] >= ($value['pts2'] / 2)) {
                    $style = 'text-success';
                } else {
                    $style = 'text-danger';
                    $condition = 'AJOURNE4';
                }
                $content .= '<td><p class="' . $style . '">' . $value['note2'] . '/' . $value['pts2'] . '</p></td>';
            } else {
                $content .= '<td></td>';
            }

            $content .= '</tr>';
        }
        $content .= '</table>';
        /* Note par point */
        $stmt = $conn->prepare('CALL notepoint(' . $id_candidat . ',' . $id_categorie . ')');
        $return_value = $stmt->execute()->fetchAll();
        $content .= '<table><tr><th>Thème</th><th>Véhicule 1</th><th>Véhicule 2</th></tr>';
        foreach ($return_value as $key => $value) {
            $content .= '<tr>';
            $content .= '<td><P>' . $value['point'] . '</p></td>';
            if ($value['note1'] != null) {
                if ($value['note1'] > 0) {
                    $style = 'text-success';
                } else {
                    $style = 'text-danger';
                    $condition = 'AJOURNE5';
                }
                $content .= '<td><p class="' . $style . '">' . $value['note1'] . '/' . $value['pts1'] . '</p></td>';
            } else {
                $content .= '<td></td>';
            }
            if ($value['note2'] != null) {
                if ($value['note2'] > 0) {
                    $style = 'text-success';
                } else {
                    $style = 'text-danger';
                    $condition = 'AJOURNE6';
                }
                $content .= '<td><p class="' . $style . '">' . $value['note2'] . '/' . $value['pts2'] . '</p></td>';
            } else {
                $content .= '<td></td>';
            }

            $content .= '</tr>';
        }
        $content .= '</table>';

        $tab[0] = $content;
        $tab[1] = $condition;
        return $tab;
    }

    public function resultatCategory($id_candidat, $id_categorie)
    {
        $conn = $this->getEntityManager()->getConnection();
        $condition = 'RECU';
        /* Note globale */
        $stmt = $conn->prepare('CALL noteglobal(' . $id_candidat . ',' . $id_categorie . ')');
        $return_value = $stmt->execute()->fetchall();

        foreach ($return_value as $value) {
            if (($value['SUM(note1)'] < 70) && ($value['SUM(note1)'] != null)) {
                $condition = 'ECHEC';
            }
            if (($value['SUM(note2)'] < 70) && ($value['SUM(note2)'] != null)) {
                $condition = 'ECHEC';
            }
        }
        /* Note par theme */
        $stmt = $conn->prepare('CALL notetheme(' . $id_candidat . ',' . $id_categorie . ')');
        $return_value = $stmt->execute()->fetchAll();
        foreach ($return_value as $key => $value) {

            if (($value['note1'] != null) && ($value['pts1'] != null)) {
                if ($value['note1'] >= ($value['pts1'] / 2)) {
                } else {
                    $condition = 'ECHEC';
                }
            }
            if (($value['note2'] != null) && ($value['pts2'] != null)) {
                if ($value['note2'] >= ($value['pts2'] / 2)) {
                } else {
                    $condition = 'ECHEC';
                }
            }
        }
        /* Note par point */
        $stmt = $conn->prepare('CALL notepoint(' . $id_candidat . ',' . $id_categorie . ')');
        $return_value = $stmt->execute()->fetchAll();
        foreach ($return_value as $key => $value) {
            if ($value['note1'] != null) {
                if ($value['note1'] > 0) {
                } else {
                    $condition = 'ECHEC';
                }
            }
            if ($value['note2'] != null) {
                if ($value['note2'] > 0) {
                } else {
                    $condition = 'ECHEC';
                }
            }
        }
        return $condition;
    }

    public function resultats_categoriePDF($pdf, $id_candidat, $id_categorie)
    {
        $conn = $this->getEntityManager()->getConnection();
        $condition = 'RECU';
        /* Note globale */
        $stmt = $conn->prepare('CALL noteglobal(' . $id_candidat . ',' . $id_categorie . ')');
        $return_value = $stmt->execute()->fetchAll();
        $chaine = '';
        foreach ($return_value as $key => $value) {
            if ($value['SUM(note1)'] < 70) {
                $condition = 'AJOURNE';
            }
            $chaine .= 'Véh1 : ' . $value['SUM(note1)'] . ' / 100  ';
            if ($value['SUM(note2)'] != null) {
                if ($value['SUM(note2)'] < 70) {
                    $condition = 'AJOURNE';
                }
                $chaine .= '- Véh2 : ' . $value['SUM(note2)'] . ' / 100  ';
            }
        }
        /* Note par theme */
        $stmt = $conn->prepare('CALL notetheme(' . $id_candidat . ',' . $id_categorie . ')');
        $return_value = $stmt->execute()->fetchAll();
        foreach ($return_value as $key => $value) {
            if ($value['note1'] != null) {
                if ($value['note1'] < ($value['pts1'] / 2)) {
                    $condition = 'AJOURNE (Echec dans un thème)';
                }
            }
            if ($value['note2'] != null) {
                if ($value['note2'] < ($value['pts2'] / 2)) {
                    $condition = 'AJOURNE (Echec dans un thème)';
                }
            }
        }
        /* Note par point */
        $stmt = $conn->prepare('CALL notepoint(' . $id_candidat . ',' . $id_categorie . ')');
        $return_value = $stmt->execute()->fetchAll();
        foreach ($return_value as $key => $value) {
            if ($value['note1'] != null) {
                if ($value['note1'] == 0) {
                    $condition = 'AJOURNE (Point = 0 Eliminatoire)';
                }
            }
            if ($value['note2'] != null) {
                if ($value['note2'] == 0) {
                    $condition = 'AJOURNE (Point = 0 Eliminatoire)';
                }
            }
        }
        $pdf->Cell(0, 10, utf8_decode($chaine . $condition), 'LBR', 1, 'C');
        return $pdf;
    }
}
