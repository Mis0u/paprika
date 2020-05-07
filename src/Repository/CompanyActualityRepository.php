<?php

namespace App\Repository;

use App\Entity\CompanyActuality;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CompanyActuality|null find($id, $lockMode = null, $lockVersion = null)
 * @method CompanyActuality|null findOneBy(array $criteria, array $orderBy = null)
 * @method CompanyActuality[]    findAll()
 * @method CompanyActuality[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompanyActualityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CompanyActuality::class);
    }

    // /**
    //  * @return CompanyActuality[] Returns an array of CompanyActuality objects
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
    public function findOneBySomeField($value): ?CompanyActuality
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
