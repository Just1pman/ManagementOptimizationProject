<?php

namespace App\Repository;

use App\Entity\CareerSummary;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CareerSummary|null find($id, $lockMode = null, $lockVersion = null)
 * @method CareerSummary|null findOneBy(array $criteria, array $orderBy = null)
 * @method CareerSummary[]    findAll()
 * @method CareerSummary[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CareerSummaryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CareerSummary::class);
    }

    // /**
    //  * @return CareerSummary[] Returns an array of CareerSummary objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CareerSummary
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
