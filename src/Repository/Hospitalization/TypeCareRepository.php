<?php

namespace App\Repository\Hospitalization;

use App\Entity\Hospitalization\TypeCare;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TypeCare|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeCare|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeCare[]    findAll()
 * @method TypeCare[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeCareRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypeCare::class);
    }

    // /**
    //  * @return TypeCare[] Returns an array of TypeCare objects
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
    public function findOneBySomeField($value): ?TypeCare
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
