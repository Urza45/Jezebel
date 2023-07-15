<?php

namespace App\Repository;

use App\Entity\Client;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Security;

/**
 * @extends ServiceEntityRepository<Client>
 *
 * @method Client|null find($id, $lockMode = null, $lockVersion = null)
 * @method Client|null findOneBy(array $criteria, array $orderBy = null)
 * @method Client[]    findAll()
 * @method Client[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClientRepository extends ServiceEntityRepository
{
    private $security;

    public function __construct(ManagerRegistry $registry, Security $security)
    {
        parent::__construct($registry, Client::class);
        $this->security = $security;
    }

    public function add(Client $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Client $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function searchByNumClient($idClient, $ville)
    {
        $user = $this->security;

        if ($idClient == null && $ville == null) {
            return 'false';
        }
        $result = $this->createQueryBuilder('o');

        if ($idClient !== null && $idClient !== null) {
            $result->where('o.nomClient LIKE :nomClient')
                ->andWhere('o.villeClient LIKE :ville')
                ->setParameter('nomClient', '%' . $idClient . '%')
                ->setParameter('ville', '%' . $ville . '%');
        }

        if ($ville == null) {
            $result->where('o.nomClient LIKE :nomClient')
                ->setParameter('nomClient', '%' . $idClient . '%');
        }

        if ($idClient == null) {
            $result->where('o.villeClient LIKE :ville')
                ->setParameter('ville', '%' . $ville . '%');
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
    //     * @return Client[] Returns an array of Client objects
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

    //    public function findOneBySomeField($value): ?Client
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
