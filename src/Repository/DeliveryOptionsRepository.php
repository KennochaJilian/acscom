<?php

namespace App\Repository;

use App\Entity\DeliveryOptions;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method DeliveryOptions|null find($id, $lockMode = null, $lockVersion = null)
 * @method DeliveryOptions|null findOneBy(array $criteria, array $orderBy = null)
 * @method DeliveryOptions[]    findAll()
 * @method DeliveryOptions[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DeliveryOptionsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DeliveryOptions::class);
    }

    // /**
    //  * @return DeliveryOptions[] Returns an array of DeliveryOptions objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DeliveryOptions
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
