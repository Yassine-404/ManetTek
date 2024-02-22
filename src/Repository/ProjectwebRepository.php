<?php

namespace App\Repository;

use App\Entity\Projectweb;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Projectweb>
 *
 * @method Projectweb|null find($id, $lockMode = null, $lockVersion = null)
 * @method Projectweb|null findOneBy(array $criteria, array $orderBy = null)
 * @method Projectweb[]    findAll()
 * @method Projectweb[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjectwebRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Projectweb::class);
    }

//    /**
//     * @return Projectweb[] Returns an array of Projectweb objects
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

//    public function findOneBySomeField($value): ?Projectweb
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
    public function findByKeyword($keyword)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.NomP LIKE :keyword')
            ->setParameter('keyword', '%'.$keyword.'%')
            ->getQuery()
            ->getResult();
    }
    public function findBycategorie(\App\Entity\Categorie $categorie): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.categorie = :categorie')
            ->setParameter('categorie', $categorie)
            ->getQuery()
            ->getResult();
    }



}
