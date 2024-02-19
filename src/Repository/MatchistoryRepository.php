<?php

namespace App\Repository;

use App\Entity\Matchistory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Matchistory>
 *
 * @method Matchistory|null find($id, $lockMode = null, $lockVersion = null)
 * @method Matchistory|null findOneBy(array $criteria, array $orderBy = null)
 * @method Matchistory[]    findAll()
 * @method Matchistory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MatchistoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Matchistory::class);
    }

//    /**
//     * @return Matchistory[] Returns an array of Matchistory objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Matchistory
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
