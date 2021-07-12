<?php

namespace App\Controller;

use App\Entity\Product;
use App\Service\CartService;
use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class HomeController extends AbstractController {

    /**
     * @Route("/", name="homepage")
    */
    public function home(ProductRepository $productRepository, CategoryRepository $categoryRepository, CartService $cartService) : Response{
        $productRepository = $this->getDoctrine()->getRepository(Product::class);
        $products = $productRepository->findAll();
        $categories = $categoryRepository->findAll();
        return $this->render(
            'users/home.html.twig',
            [
                'products' => $products,
                'categories' => $categories,
                'total' => $cartService->getTotal(),
                'items' => $cartService->getFullCart()
            ]
        );
    }
    

    /**
     * @Route("/category/{slug}", name="show_category")
     */
    public function showCategory(string $slug, ProductRepository $productRepository, CategoryRepository $categoryRepository) : Response{
        $productRepository = $this->getDoctrine()->getRepository(Product::class);
        $data = $categoryRepository->findOneBySomeField($slug);
        $products = $productRepository->findByCategory($data);
        $categories = $categoryRepository->findAll();

        return $this->render('users/home.html.twig',
            [
                'products' => $products,
                'categories' => $categories
            ]
        );


    }

}

?>