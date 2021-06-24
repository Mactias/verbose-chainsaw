<?php

namespace App\Repository;

use App\Entity\Pupil;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Pupil|null find($id, $lockMode = null, $lockVersion = null)
 * @method Pupil|null findOneBy(array $criteria, array $orderBy = null)
 * @method Pupil[]    findAll()
 * @method Pupil[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PupilRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Pupil::class);
    }


    public function findByManyFields($id, $sex, $class)
    {
        $qb = $this->createQueryBuilder('p')
            ->orderBy('p.name', 'ASC');

        if ($id !== 'empty') {
            $qb->andWhere('p.id = :id')
                ->setParameter('id', $id);
        }
        if ($sex !== 'empty') {
            $qb->andWhere('p.sex = :sex')
                ->setParameter('sex', $sex);
        }
        if ($class !== 'empty') {
            $qb->andWhere('p.class= :class')
                ->setParameter('class', $class);
        }
        return $qb->getQuery()->getResult();
    }
    // /**
    //  * @return Pupil[] Returns an array of Pupil objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Pupil
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
