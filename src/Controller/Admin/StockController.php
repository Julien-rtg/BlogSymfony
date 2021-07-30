<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StockController extends AbstractController {

    /**
     * @Route("/admin/stock", name="index_stock")
     */
    public function index(ProductRepository $productRepository): Response {
        $productRepository = $this->getDoctrine()->getRepository(Product::class);
        $products = $productRepository->findAll();

        return $this->render('admin/stock/index.html.twig', [
            'products' => $products
        ]);
    }

    /**
     * @Route("/admin/add/stock/{id}", name="add_stock")
     */
    public function addStock(Product $product): Response {

        $check = $product->getStock();
        if($check == true){
            return $this->redirectToRoute('index_stock');
        }

        $stock = $product->setStock(true);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($stock);
        $entityManager->flush();

        return $this->redirectToRoute('index_stock');
    }

    /**
     * @Route("/admin/remove/stock/{id}", name="remove_stock")
     */
    public function removeStock(Product $product): Response{
        
        $check = $product->getStock();
        if($check == false){
            return $this->redirectToRoute('index_stock');
        }

        $stock = $product->setStock(false);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($stock);
        $entityManager->flush();

        return $this->redirectToRoute('index_stock');
    }
}
