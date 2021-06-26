<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

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

    public function findByCategory($data){

        return $this->createQueryBuilder('p')
            ->innerJoin('p.categories', 'c')
            ->where('c.id = :category_id')
            ->setParameter('category_id', $data->getId())
            ->getQuery()
            ->getResult();

    }

        // récupérer les produits correspondant a l'id de la categorie

        // TABLE CATEGORIE
        // slug -> categorie ID

        // TABLE PRODUCT_CATEGORIE
        // categorie ID -> récupere ID du produit

        // TABLE PRODUCT
        // id du produit -> tout le produit

}
