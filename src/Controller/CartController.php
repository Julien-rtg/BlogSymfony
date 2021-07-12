<?php

namespace App\Controller;


use App\Service\CartService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class CartController extends AbstractController{

    /**
     * @Route ("/cart", name = "cart")
     */
    public function cart(CartService $cartservice){

        return $this->render(
            'users/cart.html.twig',
            [
                'items' => $cartservice->getFullCart(),
                'total' => $cartservice->getTotal()
            ]
        );
    }

    /**
     * @Route ("/cart/add/{id}", name = "add_cart")
     */
    public function add($id, CartService $cartservice, Request $request){
        $cartservice->add($id);

        return $this->redirectToRoute('homepage');
    }


    /**
     * @Route ("/cart/remove/{id}", name="remove_cart")
     */
    public function remove($id, CartService $cartservice){
        $cartservice->remove($id);

        return $this->redirectToRoute('homepage');
    }

    
    /**
     * @Route ("/cart/delete/{id}", name="delete_cart")
     */
    public function delete($id, CartService $cartservice){
        $cartservice->delete($id);

        return $this->redirectToRoute('homepage');
    }

}