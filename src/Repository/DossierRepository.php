<?php

namespace App\Repository;

use App\Entity\Dossier;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Security;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Dossier>
 *
 * @method Dossier|null find($id, $lockMode = null, $lockVersion = null)
 * @method Dossier|null findOneBy(array $criteria, array $orderBy = null)
 * @method Dossier[]    findAll()
 * @method Dossier[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DossierRepository extends ServiceEntityRepository
{
    private $security;

    public function __construct(ManagerRegistry $registry, Security $security)
    {
        parent::__construct($registry, Dossier::class);
        $this->security = $security;
    }

    public function add(Dossier $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Dossier $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function searchByNumClient($numDossier, $client)
    {
        $user = $this->security;

        if ($numDossier == null && $client == null) {
            return 'false';
        }
        $result = $this->createQueryBuilder('o');

        if ($numDossier !== null && $client !== null) {
            $result->where('o.numDossier LIKE :numDossier')
                ->andWhere('o.idClient = :client')
                ->setParameter('client', $client)
                ->setParameter('numDossier', '%' . $numDossier . '%');
        }

        if ($numDossier == null) {
            $result->where('o.idClient = :client')
                ->setParameter('client', $client);
        }

        if ($client == null) {
            $result->where('o.numDossier like :numDossier')
                ->setParameter('numDossier', '%' . $numDossier . '%');
        }

        if ($user->isGranted('ROLE_ULTRAADMIN')) {
            // code...
        } else {
            $result->andWhere('o.society = :society')
                ->setParameter('society', $user->getUser()->getSociety());
        }
        return $result->getQuery()->getResult();
    }
    //    /**
    //     * @return Dossier[] Returns an array of Dossier objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('d')
    //            ->andWhere('d.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('d.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Dossier
    //    {
    //        return $this->createQueryBuilder('d')
    //            ->andWhere('d.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
