<?php

namespace App\Controller\Security;

use App\Entity\Product;
use App\Entity\Category;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController {
    
    /**
     * @Route("/product", name="index_product")
     */
    public function index(ProductRepository $productRepository){
        $productRepository = $this->getDoctrine()->getRepository(Product::class);
        $products = $productRepository->findAll();

        return $this->render('Security/product/index.html.twig', [
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

            $this->addFlash(
                'success',
                "Le produit {$product->getName()} a bien été ajouté !",
            );

            return $this->redirectToRoute('index_product');
        }

        return $this->render('Security/product/new.html.twig', [
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

            $this->addFlash(
                'success',
                "Le produit {$product->getName()} a bien été modifié !",
            );

            return $this->redirectToRoute('index_product');
        }

        return $this->render('Security/product/edit.html.twig', [
            'form' => $form->createView(),
            'product' => $product
        ]);
    }

    /**
     * @Route("/remove-product/{id}", name="remove_product")
     */
    public function removeProduct(Product $product, Request $request): Response {
        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $product = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($product);
            $entityManager->flush();

            $this->addFlash(
                'danger',
                "Le produit {$product->getName()} a bien été supprimé !",
            );

            return $this->redirectToRoute('index_product');
        }

        return $this->render('Security/product/remove.html.twig', [
            'form' => $form->createView(),
            'product' => $product
        ]);
    }

}
