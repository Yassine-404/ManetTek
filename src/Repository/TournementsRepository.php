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

    /**
     * Trouver les tournois avec des réservations.
     *
     * @return Tournements[] Les tournois avec des réservations
     */
    public function findWithReservations(): array
    {
        return $this->createQueryBuilder('t')
            ->innerJoin('t.reservations', 'r')
            ->getQuery()
            ->getResult();
    }

    /**
     * Recherche les tournois par nom.
     *
     * @param string $nom Le nom du tournoi à rechercher
     * @return Tournements[] Les tournois correspondants au nom donné
     */
    public function findByNom(string $nom): array
    {
        return $this->createQueryBuilder('t')
            ->where('t.nom LIKE :nom')
            ->setParameter('nom', '%'.$nom.'%')
            ->getQuery()
            ->getResult();
    }

    /**
     * Recherche les tournois par terme dans les champs pertinents.
     *
     * @param string $term Le terme de recherche
     * @return Tournements[] Les tournois correspondants au terme de recherche
     */
    public function searchByTerm(string $term): array
    {
        return $this->createQueryBuilder('t')
            ->where('t.nom LIKE :term')
            ->orWhere('t.jeu LIKE :term')
            ->orWhere('t.lieu LIKE :term')
            ->orWhere('t.description LIKE :term')
            ->setParameter('term', '%'.$term.'%')
            ->getQuery()
            ->getResult();
    }
}
