<?php

namespace App\Repository;

use App\Entity\Subject;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Subject|null find($id, $lockMode = null, $lockVersion = null)
 * @method Subject|null findOneBy(array $criteria, array $orderBy = null)
 * @method Subject[]    findAll()
 * @method Subject[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SubjectRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Subject::class);
    }

    public function findByNameCI()
    {
        $query = $this->getEntityManager()->createQuery(
            'SELECT s
            FROM App\Entity\Subject s
            ORDER BY LOWER(s.name) ASC'
        );

        return $query->getResult();
    }
    /* public function findAllByFields($name, $teacher, $class) { */
    /*     if($name === 'empty' && $teacher === 'empty' && $class === 'empty') { */
    /*         return $this->findAll(); */
    /*     } */
    /*     if($name !== 'empty') { */
    /*     } */
    /*     $qb = false; */
    /*     if($name !== 'empty') { */
    /*         $qb = $this->createQueryBuilder('s') */
    /*             ->andWhere('s.= :name') */
    /*             ->setParameter('name', $name) */
    /*     } */
    /*     if ($teacher !== 'empty' && $qb === false) { */
    /*         $qb = $this->createQueryBuilder('s') */
    /*             ->andWhere('s.= :teacher') */
    /*             ->setParameter('teacher', $teacher) */
    /*     } */
    /* } */
    // /**
    //  * @return Subject[] Returns an array of Subject objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Subject
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
