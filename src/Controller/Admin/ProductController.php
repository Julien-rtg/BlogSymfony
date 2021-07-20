<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use App\Entity\Category;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\String\Slugger\SluggerInterface;

class ProductController extends AbstractController {
    
    /**
     * @Route("/admin/product", name="index_product")
     */
    public function index(ProductRepository $productRepository){
        $productRepository = $this->getDoctrine()->getRepository(Product::class);
        $products = $productRepository->findAll();

        return $this->render('admin/product/index.html.twig', [
            'products' => $products
        ]);
    }

    /**
     * @Route("/admin/add-product", name="create_product")
     */
    public function createProduct(Request $request, SluggerInterface $slugger): Response {
        $product = new Product();

        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $product = $form->getData();

            $file = $form->get('image')->getData();
            $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = $slugger->slug($originalFilename);
            $newFilename = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();
            try{
                $file->move('img', $newFilename);
            } catch(FileException $e){
                return $e->getMessage();
            }

            $product->setImage($newFilename);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($product);
            $entityManager->flush();

            $this->addFlash(
                'success',
                "Le produit <strong>{$product->getName()}</strong> a bien été ajouté !",
            );

            return $this->redirectToRoute('index_product');
        }

        return $this->render('admin/product/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/admin/edit-product/{id}", name="edit_product")
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
                "Le produit <strong>{$product->getName()}</strong> a bien été modifié !",
            );

            return $this->redirectToRoute('index_product');
        }

        return $this->render('admin/product/edit.html.twig', [
            'form' => $form->createView(),
            'product' => $product
        ]);
    }

    /**
     * @Route("/admin/remove-product/{id}", name="remove_product")
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
                "Le produit <strong>{$product->getName()}</strong> a bien été supprimé !",
            );

            return $this->redirectToRoute('index_product');
        }

        return $this->render('admin/product/remove.html.twig', [
            'form' => $form->createView(),
            'product' => $product
        ]);
    }

}
