<?php

namespace App\Repository\Hospitalization;

use App\Entity\Hospitalization\Care;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Care|null find($id, $lockMode = null, $lockVersion = null)
 * @method Care|null findOneBy(array $criteria, array $orderBy = null)
 * @method Care[]    findAll()
 * @method Care[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CareRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Care::class);
    }

    // /**
    //  * @return Care[] Returns an array of Care objects
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
    public function findOneBySomeField($value): ?Care
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
