<?php

namespace App\Service;

use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;

class CategoryService {

    protected $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    public function addCategory(){

        $category = new Category();
        $category->setName('Test');
        
        $this->entityManager->persist($category);
        $this->entityManager->flush();

        $data[] = [
            'id' => $category->getId(),
            'name' => $category->getName()
        ];

        return $data;
    }


    public function removeCategory(int $id){

        $category = $this->entityManager->getRepository(Category::class)->find($id);

        if(!$category){
            throw $this->createNotFoundException(
                'No found product with id'. $id
            );
        }

        $data[] = [
            'id' => $category->getId(),
            'name' => $category->getName()
        ];

        $this->entityManager->remove($category);
        $this->entityManager->flush();

        return $data;
    }

}