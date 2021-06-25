<?php

namespace App\Controller\Create;

use App\Entity\Category;
use App\Entity\Product;
use App\Service\ProductService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{
    
    /**
     * @Route("/add-product", name="create_product")
     */
    public function createProduct(ProductService $productService): Response
    {
        $data = $productService->createProduct();

        return new Response('Saved new product ' . $data[0]['id'] . ' and with name ' . $data[0]['name']);
    }

    /**
     * @Route("/remove-product/{id}", name="remove_product")
     */
    public function removeProduct(int $id, ProductService $productService): Response {

        $data = $productService->removeProduct($id);

        return new Response('Delete product with name ' . $data[0]['name']);
    }

    /**
     * @Route("/new-relation-product/{id}", name="new_relation_product_category")
     */
    public function newRelationToCategory(int $id, EntityManagerInterface $entityManager) : Response{

        $product = $entityManager->getRepository(Product::class)->find($id);

        $category = $entityManager->getRepository(Category::class)
            ->findOneBy(['name' => 'Hot Meals']); // MAKING RELATION OF CATEGORY HERE
        $product->addCategory($category);

        $entityManager->persist($product);
        $entityManager->flush();

        return new Response('Add relation ' . $product->getName() . ' to ' . $category->getName());
    }

    /**
     * @Route("/remove-relation-product/{id}", name="remove_relation_product_category")
     */
    public function removeRelationToCategory(int $id, EntityManagerInterface $entityManager) : Response{

        $product = $entityManager->getRepository(Product::class)->find($id);

        $category = $entityManager->getRepository(Category::class)
            ->findOneBy(['name' => 'Hot Meals']); // REMOVE RELATION OF CATEGORY HERE
        $product->removeCategory($category);

        $entityManager->persist($product);
        $entityManager->flush();

        return new Response('Remove relation ' . $product->getName() . ' to ' . $category->getName());
    }

}
