<?php

namespace App\Controller\Create;

use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoryController extends AbstractController
{
    
    /**
     * @Route("/add-category", name="create_category")
     */
    public function createCategory(EntityManagerInterface $entityManager): Response
    {
        // you can fetch the EntityManager via $this->getDoctrine()
        // or you can add an argument to the action: createProduct(EntityManagerInterface $entityManager)

        $category = new Category();
        $category->setName('Snack');

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($category);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Saved new CATEGORY with id '. $category->getId() . ' and name ' . $category->getName());
    }


    /**
     * @Route("/remove-category/{id}", name="remove_category")
     */
    public function removeCategory(int $id, EntityManagerInterface $entityManager): Response {

        $category = $entityManager->getRepository(Category::class)->find($id);

        if(!$category){
            throw $this->createNotFoundException(
                'No found product with id'. $id
            );
        }

        $entityManager->remove($category);
        $entityManager->flush();

        return new Response('Delete category with id '. $category->getId() . ' and name ' . $category->getName());
    }



}
