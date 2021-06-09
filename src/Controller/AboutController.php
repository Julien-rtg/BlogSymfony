<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AboutController extends AbstractController {

    /**
     * @Route("/about", name = "about")
     */
    public function about(){
        return $this->render(
            'users/about.html.twig'
        );
    }

}