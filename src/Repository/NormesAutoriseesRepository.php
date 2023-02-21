<?php

namespace App\Repository;

use App\Entity\NormesAutorisees;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<NormesAutorisees>
 *
 * @method NormesAutorisees|null find($id, $lockMode = null, $lockVersion = null)
 * @method NormesAutorisees|null findOneBy(array $criteria, array $orderBy = null)
 * @method NormesAutorisees[]    findAll()
 * @method NormesAutorisees[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NormesAutoriseesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NormesAutorisees::class);
    }

    public function add(NormesAutorisees $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(NormesAutorisees $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    //    /**
    //     * @return NormesAutorisees[] Returns an array of NormesAutorisees objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('n')
    //            ->andWhere('n.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('n.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?NormesAutorisees
    //    {
    //        return $this->createQueryBuilder('n')
    //            ->andWhere('n.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
