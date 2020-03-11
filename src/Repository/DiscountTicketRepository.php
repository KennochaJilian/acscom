<?php

namespace App\Repository;

use App\Entity\DiscountTicket;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method DiscountTicket|null find($id, $lockMode = null, $lockVersion = null)
 * @method DiscountTicket|null findOneBy(array $criteria, array $orderBy = null)
 * @method DiscountTicket[]    findAll()
 * @method DiscountTicket[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DiscountTicketRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DiscountTicket::class);
    }

    // /**
    //  * @return DiscountTicket[] Returns an array of DiscountTicket objects
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
    public function findOneBySomeField($value): ?DiscountTicket
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
