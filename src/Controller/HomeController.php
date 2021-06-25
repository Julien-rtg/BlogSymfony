<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class HomeController extends AbstractController {

    /**
     * @Route("/", name="homepage")
    */
    public function home(ProductRepository $productRepository, CategoryRepository $categoryRepository) : Response{
        $productRepository = $this->getDoctrine()->getRepository(Product::class);
        $products = $productRepository->findAll();
        $categories = $categoryRepository->findAll();
        return $this->render(
            'users/home.html.twig',
            [
                'products' => $products,
                'categories' => $categories
            ]
        );
    }

    public function category(ProductRepository $productRepository, CategoryRepository $categoryRepository) : Response{



        return $this->render('');
    }
       
}

?>