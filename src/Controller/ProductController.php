<?php

namespace App\Controller;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{
    
    /**
     * @Route("/add-product", name="create_product")
     */
    public function createProduct(EntityManagerInterface $entityManager): Response
    {
        // you can fetch the EntityManager via $this->getDoctrine()
        // or you can add an argument to the action: createProduct(EntityManagerInterface $entityManager)

        $product = new Product();
        $product->setName('Casse croute');
        $product->setPrice(2130);
        $product->setDescription('Oui Oui très bon!');
        $product->setCategory('Snack');
        $product->setImage('https://via.placeholder.com/350x350');
        
        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($product);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Saved new product with id '. $product->getId() . ' and name ' . $product->getName());
    }
}
