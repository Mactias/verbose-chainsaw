<?php

namespace App\Repository;

use App\Entity\ClassSchool;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ClassSchool|null find($id, $lockMode = null, $lockVersion = null)
 * @method ClassSchool|null findOneBy(array $criteria, array $orderBy = null)
 * @method ClassSchool[]    findAll()
 * @method ClassSchool[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClassSchoolRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ClassSchool::class);
    }

    // /**
    //  * @return ClassSchool[] Returns an array of ClassSchool objects
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
    public function findOneBySomeField($value): ?ClassSchool
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
