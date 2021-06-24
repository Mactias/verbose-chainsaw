<?php

namespace App\Repository;

use App\Entity\CourseGrades;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CourseGrades|null find($id, $lockMode = null, $lockVersion = null)
 * @method CourseGrades|null findOneBy(array $criteria, array $orderBy = null)
 * @method CourseGrades[]    findAll()
 * @method CourseGrades[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CourseGradesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CourseGrades::class);
    }

    // /**
    //  * @return CourseGrades[] Returns an array of CourseGrades objects
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
    public function findOneBySomeField($value): ?CourseGrades
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
