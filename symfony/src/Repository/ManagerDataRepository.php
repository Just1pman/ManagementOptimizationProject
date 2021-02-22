<?php

namespace App\Repository;

use App\Entity\ManagerData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ManagerData|null find($id, $lockMode = null, $lockVersion = null)
 * @method ManagerData|null findOneBy(array $criteria, array $orderBy = null)
 * @method ManagerData[]    findAll()
 * @method ManagerData[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ManagerDataRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ManagerData::class);
    }

    // /**
    //  * @return ManagerData[] Returns an array of ManagerData objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ManagerData
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
