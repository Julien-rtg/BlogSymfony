<?php

namespace App\Controller;


use App\Service\CartService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class CartController extends AbstractController{

    /**
     * @Route ("/cart", name = "cart")
     */
    public function cart(CartService $cartservice, SessionInterface $session){
        
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
        $route = $request->headers->get('referer');

        if($request->isXmlHttpRequest()){
            return new JsonResponse([
                'content' => $this->renderView('elements/cart.html.twig', [
                    'items' => $cartservice->getFullCart(),
                    'total' => $cartservice->getTotal()
                ])
            ]);
        }

        return new RedirectResponse($route);
    }

    /**
     * @Route ("/cart/recalc/{id}", name="recalc_cart")
     */
    public function recalc(int $id, CartService $cartservice, Request $request){
        $cartservice->recalc($id);
        $route = $request->headers->get('referer');

        return new RedirectResponse($route);
    }

    /**
     * @Route ("/cart/remove/{id}", name="remove_cart")
     */
    public function remove($id, CartService $cartservice, Request $request){
        $cartservice->remove($id);
        $route = $request->headers->get('referer');

        if($request->isXmlHttpRequest()){
            return new JsonResponse([
                'content' => $this->renderView('elements/cart.html.twig', [
                    'items' => $cartservice->getFullCart(),
                    'total' => $cartservice->getTotal()
                ])
            ]);
        }

        return new RedirectResponse($route);
    }

    
    /**
     * @Route ("/cart/delete/{id}", name="delete_cart")
     */
    public function delete($id, CartService $cartservice, Request $request){
        $cartservice->delete($id);
        $route = $request->headers->get('referer');

        if($request->isXmlHttpRequest()){
            return new JsonResponse([
                'content' => $this->renderView('elements/cart.html.twig', [
                    'items' => $cartservice->getFullCart(),
                    'total' => $cartservice->getTotal()
                ])
            ]);
        }

        return new RedirectResponse($route);
    }

}