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
    public function showCategory(string $slug, ProductRepository $productRepository, CategoryRepository $categoryRepository, CartService $cartService) : Response{
        $productRepository = $this->getDoctrine()->getRepository(Product::class);
        $data = $categoryRepository->findOneBySomeField($slug); // GET ALL CATEGORY WHO MATCH WITH THE SLUG PASSED IN URL, SLUG IS THE CATEGORY NAME
        $products = $productRepository->findByCategory($data); // GET ALL PRODUCT WHO MATCH WITH CATEGORY
        $categories = $categoryRepository->findAll();

        return $this->render('users/home.html.twig',
            [
                'products' => $products,
                'categories' => $categories,
                'total' => $cartService->getTotal(),
                'items' => $cartService->getFullCart()
            ]
        );


    }

}

?>