<?php

namespace App\Repository;

use App\Entity\Tournements;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Tournements>
 *
 * @method Tournements|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tournements|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tournements[]    findAll()
 * @method Tournements[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TournementsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tournements::class);
    }

//    /**
//     * @return Tournements[] Returns an array of Tournements objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Tournements
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
