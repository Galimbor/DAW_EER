<?php

namespace App\Repository;

use App\Entity\Petcategories;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Petcategories|null find($id, $lockMode = null, $lockVersion = null)
 * @method Petcategories|null findOneBy(array $criteria, array $orderBy = null)
 * @method Petcategories[]    findAll()
 * @method Petcategories[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PetcategoriesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Petcategories::class);
    }

    // /**
    //  * @return Petcategories[] Returns an array of Petcategories objects
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
    public function findOneBySomeField($value): ?Petcategories
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
