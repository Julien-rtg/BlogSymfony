<?php

namespace App\Controller\Create;

use App\Entity\Category;
use App\Service\CategoryService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoryController extends AbstractController
{
    
    /**
     * @Route("/add-category", name="create_category")
     */
    public function createCategory(CategoryService $categoryService): Response
    {
        $data = $categoryService->addCategory();

        return new Response('Saved new CATEGORY with id '. $data[0]['id'] . ' and name ' . $data[0]['name']);
    }


    /**
     * @Route("/remove-category/{id}", name="remove_category")
     */
    public function removeCategory(int $id, CategoryService $categoryService): Response {

        $data = $categoryService->removeCategory($id);

        return new Response('Remove CATEGORY with id '. $data[0]['id'] . ' and name ' . $data[0]['name']);
    }



}
