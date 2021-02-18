<?php

namespace App\Repository;

use App\Entity\Adoptions;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Adoptions|null find($id, $lockMode = null, $lockVersion = null)
 * @method Adoptions|null findOneBy(array $criteria, array $orderBy = null)
 * @method Adoptions[]    findAll()
 * @method Adoptions[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdoptionsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Adoptions::class);
    }

    // /**
    //  * @return Adoptions[] Returns an array of Adoptions objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Adoptions
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
