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
    public function newRelationToCategory(int $id, ProductService $productService) : Response{

        $data = $productService->newRelation($id);

        return new Response('Add relation with id ' . $data[0]['idProduct'] . ' and with name '. $data[0]['nameProduct'] . ' to id ' . $data[0]['idCategory'] . ' and with name ' . $data[0]['nameCategory']);
    }

    /**
     * @Route("/remove-relation-product/{id}", name="remove_relation_product_category")
     */
    public function removeRelationToCategory(int $id, ProductService $productService) : Response{

        $data = $productService->removeRelation($id);

        return new Response('Remove relation with id ' . $data[0]['idProduct'] . ' and with name '. $data[0]['nameProduct'] . ' to id ' . $data[0]['idCategory'] . ' and with name ' . $data[0]['nameCategory']);
    }

}
