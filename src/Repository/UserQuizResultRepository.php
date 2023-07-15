<?php

namespace App\Repository;

use App\Entity\Candidat;
use App\Entity\Quiz;
use App\Entity\UserQuizResult;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UserQuizResult>
 *
 * @method UserQuizResult|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserQuizResult|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserQuizResult[]    findAll()
 * @method UserQuizResult[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserQuizResultRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserQuizResult::class);
    }

    public function add(UserQuizResult $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(UserQuizResult $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getNoteGlobale(Candidat $candidat, UserQuizResult $userQuizResult)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            select sum(pts) noteGlobale from user_quiz_answer a, user_quiz_result r 
            where a.user_quiz_result_id = r.id and r.id = :quiz and r.candidat_id = :candidat;
            ';

        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(
            [
                'quiz' => $userQuizResult->getId(),
                'candidat' => $candidat->getId()
            ]
        );

        // returns an array of arrays (i.e. a raw data set)
        return $resultSet->fetchAllAssociative();
    }

    public function getNotesThemes(Candidat $candidat, UserQuizResult $userQuizResult)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        select sum(uqa.pts) note, tt.intitule, tt.pts from user_quiz_answer uqa  
        inner join user_quiz_result uqr on uqr.id = uqa.user_quiz_result_id 	
        inner join questions q on uqa.question_id = q.id 
        inner join sous_theme st on q.sous_theme_id = st.id 
        inner join theme_theorique tt on st.theme_theorique_id = tt.id 
        where uqr.id = :quiz and uqr.candidat_id = :candidat
        group by tt.id
            ';

        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(
            [
                'quiz' => $userQuizResult->getId(),
                'candidat' => $candidat->getId()
            ]
        );

        // returns an array of arrays (i.e. a raw data set)
        return $resultSet->fetchAllAssociative();
    }

    public function getResultQuiz(Candidat $candidat, UserQuizResult $userQuizResult)
    {
        $resultat = 'RECU';

        $noteGlobal = $this->getNoteGlobale($candidat, $userQuizResult)[0]['noteGlobale'];

        if ($noteGlobal < 70) {
            $resultat = 'ECHEC';
        } else {
            $notesThemes = $this->getNotesThemes($candidat, $userQuizResult);
            foreach ($notesThemes as $tab) {
                $note = $tab['note'];
                $noteMax = $tab['pts'];
                if ($note < ($noteMax / 2)) {
                    $resultat = 'ECHEC';
                }
            }
        }
        return $resultat;
    }

    //    /**
    //     * @return UserQuizResult[] Returns an array of UserQuizResult objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('u.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?UserQuizResult
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
