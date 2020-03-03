<?php

namespace App\Repository;

use App\Entity\CategoryQuestions;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method CategoryQuestions|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategoryQuestions|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategoryQuestions[]    findAll()
 * @method CategoryQuestions[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryQuestionsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategoryQuestions::class);
    }

    // /**
    //  * @return CategoryQuestions[] Returns an array of CategoryQuestions objects
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
    public function findOneBySomeField($value): ?CategoryQuestions
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
