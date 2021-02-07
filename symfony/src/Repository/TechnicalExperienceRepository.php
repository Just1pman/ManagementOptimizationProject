<?php

namespace App\Repository;

use App\Entity\TechnicalExperience;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TechnicalExperience|null find($id, $lockMode = null, $lockVersion = null)
 * @method TechnicalExperience|null findOneBy(array $criteria, array $orderBy = null)
 * @method TechnicalExperience[]    findAll()
 * @method TechnicalExperience[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TechnicalExperienceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TechnicalExperience::class);
    }

    // /**
    //  * @return TechnicalExperience[] Returns an array of TechnicalExperience objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TechnicalExperience
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
