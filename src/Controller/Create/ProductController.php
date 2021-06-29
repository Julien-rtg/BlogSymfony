<?php

namespace App\Controller\Create;

use App\Entity\Product;
use App\Entity\Category;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use App\Service\ProductService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{
    
    /**
     * @Route("/product", name="index_product")
     */
    public function index(ProductRepository $productRepository){
        $productRepository = $this->getDoctrine()->getRepository(Product::class);
        $products = $productRepository->findAll();

        return $this->render('product/index.html.twig', [
            'products' => $products
        ]);
    }

    /**
     * @Route("/add-product", name="create_product")
     */
    public function createProduct(Request $request): Response {
        $product = new Product();

        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $product = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute('index_product');
        }

        return $this->render('product/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/edit-product/{id}", name="edit_product")
     */
    public function editProduct(Product $product, Request $request) : Response {
        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $product = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute('index_product');
        }

        return $this->render('product/edit.html.twig', [
            'form' => $form->createView(),
            'product' => $product
        ]);
    }


    /**
     * @Route("/remove-product/{id}", name="remove_product")
     */
    public function removeProduct(int $id, ProductService $productService): Response {
        // $data = $productService->removeProduct($id);
        // return new Response('Delete product with name ' . $data[0]['name']);

        return $this->render('product/delete.html.twig');
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
