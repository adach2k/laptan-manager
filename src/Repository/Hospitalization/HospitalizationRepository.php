<?php

namespace App\Repository\Hospitalization;

use App\Entity\Hospitalization\Hospitalization;
use App\Entity\Appointment\Patient;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Hospitalization|null find($id, $lockMode = null, $lockVersion = null)
 * @method Hospitalization|null findOneBy(array $criteria, array $orderBy = null)
 * @method Hospitalization[]    findAll()
 * @method Hospitalization[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HospitalizationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Hospitalization::class);
    }

    // /**
    //  * @return Hospitalization[] Returns an array of Hospitalization objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('h.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Hospitalization
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
