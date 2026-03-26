<?php

namespace App\Repository;

use App\Entity\ArtBasket;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ArtBasket>
 */
class ArtBasketRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ArtBasket::class);
    }

    //    /**
    //     * @return ArtBasket[] Returns an array of ArtBasket objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('a.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?ArtBasket
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
