<?php

namespace App\Repository;

use App\Entity\Pmatch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Pmatch>
 *
 * @method Pmatch|null find($id, $lockMode = null, $lockVersion = null)
 * @method Pmatch|null findOneBy(array $criteria, array $orderBy = null)
 * @method Pmatch[]    findAll()
 * @method Pmatch[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PmatchRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Pmatch::class);
    }

//    /**
//     * @return Pmatch[] Returns an array of Pmatch objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Pmatch
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
