<?php

namespace App\Controller\Admin;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController {

    /**
     * @Route("/admin", name="home_admin")
     */
    public function index() : Response {

        return $this->render('admin/index.html.twig');
        
    }

}