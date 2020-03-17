<?php

namespace App\Repository;

use App\Data\SearchData;
use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\ResultSetMapping;


/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    // /**
    //  * @return Product[] Returns an array of Product objects
    //  */
    
    // public function findByExampleField($value)
    // {
    //     return $this->createQueryBuilder('p')
    //         ->andWhere('p.exampleField = :val')
    //         ->setParameter('val', $value)
    //         ->orderBy('p.id', 'ASC')
    //         ->setMaxResults(10)
    //         ->getQuery()
    //         ->getResult()
    //     ;
    // }
    

    /*
    public function findOneBySomeField($value): ?Product
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    /**
     * 
     * Recupère les produits en lien avec une recherche
     * @return Product[] 
     */

    public function findSearch(SearchData $search):array
    {

        $query = $this
            ->createQueryBuilder('p')
            ->select('c','p')
            ->join('p.category', 'c');

        
        if(!empty($search->q)){
            
            $query = $query
                ->leftJoin('p.tag', 't')
                ->andWhere('p.name LIKE :q or t.name LIKE :q')                
                ->setParameter('q', "%{$search->q}%");

        }

        if(!empty($search->min)){
            
            $query = $query
                ->andWhere('p.price >= :min')
                ->setParameter('min', $search->min);
            

        }

        if(!empty($search->max)){
            
            $query = $query
                ->andWhere('p.price <= :max')
                ->setParameter('max', $search->max);   

        }

        if(!empty($search->categories)){
            
            $query = $query
                ->andWhere('c.id IN (:categories)')
                ->setParameter('categories', $search->categories);
                
        }

        return $query->getQuery()->getResult();

    }

    public function getProductAssociated($idProduct)
    {

        $conn= $this->getEntityManager()->getConnection();
        $sql = 'SELECT * from product, product_tag where product.id = product_tag.product_id AND product_tag.tag_id IN (select tag_id FROM product_tag WHERE product_id = :idProduct) AND product.id != :idProduct'; 
        $stmt = $conn->prepare($sql); 
        $stmt->execute(['idProduct' => $idProduct]);

        return $stmt->fetchAll();
    }

}
