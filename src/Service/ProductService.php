<?php

namespace App\Service;

use App\Entity\Product;
use App\Entity\Category;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProductService {

    protected $productRepository;
    protected $entityManager;

    public function __construct(ProductRepository $productRepository, EntityManagerInterface $entityManager){
        $this->productRepository = $productRepository;
        $this->entityManager = $entityManager;
    }


    public function createProduct(){
        
        $product = new Product();
        $product->setName('Saucisse');
        $product->setPrice(43);
        $product->setDescription('Description');
        $product->setImage('https://via.placeholder.com/350x350');
        
        $category = $this->entityManager->getRepository(Category::class)
            ->findOneBy(['name' => 'Snack']);
        $product->addCategory($category);

        $this->entityManager->persist($product);
        $this->entityManager->flush();

        $data[] = [
            'id' => $product->getId(),
            'name' => $product->getName()
        ];

        return $data;
    }


    public function removeProduct(int $id){

        $product = $this->entityManager->getRepository(Product::class)->find($id);

        if(!$product){
            throw new NotFoundHttpException('The product ' . $id .' does not exist');
        }

        $data[] = [
            'id' => $product->getId(),
            'name' => $product->getName()
        ];

        $this->entityManager->remove($product);
        $this->entityManager->flush();

        return $data;
    }

    public function newRelation(int $id){

        $product = $this->entityManager->getRepository(Product::class)->find($id);

        $category = $this->entityManager->getRepository(Category::class)
            ->findOneBy(['name' => 'Hot Meals']); // MAKING RELATION OF CATEGORY HERE
        $product->addCategory($category);

        $this->entityManager->persist($product);
        $this->entityManager->flush();

        $data[] = [
            'idProduct' => $product->getId(),
            'nameProduct' => $product->getName(),
            'idCategory' => $category->getId(),
            'nameCategory' => $category->getName()
        ];

        return $data;
    }


    public function removeRelation(int $id){
        $product = $this->entityManager->getRepository(Product::class)->find($id);

        $category = $this->entityManager->getRepository(Category::class)
            ->findOneBy(['name' => 'Hot Meals']); // REMOVE RELATION OF CATEGORY HERE
        $product->removeCategory($category);

        $data[] = [
            'idProduct' => $product->getId(),
            'nameProduct' => $product->getName(),
            'idCategory' => $category->getId(),
            'nameCategory' => $category->getName()
        ];

        $this->entityManager->persist($product);
        $this->entityManager->flush();

        return $data;
    }

}