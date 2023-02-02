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
               ->getResult()
           ;
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
                    } else {
                        $content .= '<input type="number" name="note_1[' . $increment . ']" value="" size="1" disabled />/';
                    }
                    $content .= ' - ';
                    if ($critere['ptse2'] > 0) {
                        $content .= '<input type="number" name="note_2[' . $increment . ']" value="';
                        if ($tabNote2 !== null) {
                            $content .= $tabNote2[$increment];
                        }
                        $content .= '" size="3" min="0" max="' . $critere['ptse2'] . '" required />' . $critere['ptse2'] . "\n";
                    } else {
                        $content .= '<input type="number" name="note_2[' . $increment . ']" value="" size="1" disabled />';
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
        return utf8_encode($content);
    }
}
