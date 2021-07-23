<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserAccountController extends AbstractController
{
    /**
     * @Route("/user/account", name="user_account")
     */
    public function index(): Response{
        // IF NOT CONNECTED
        if(!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }

        
        {
            return $this->render('users/userAccount.html.twig');
        }

    }

}