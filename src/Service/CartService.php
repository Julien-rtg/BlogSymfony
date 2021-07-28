<?php

namespace App\Service;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


class CartService {

    protected $requestStack;
    protected $productRepository;

    public function __construct(RequestStack $requestStack, ProductRepository $productRepository){
        $this->requestStack = $requestStack;
        $this->productRepository = $productRepository;
    }

    public function add(int $id){
        $session = $this->requestStack->getSession();
        $cart = $session->get('cart', []);

        if(isset($cart[$id])){
            $cart[$id]++;
        } else {
            $cart[$id] = 1;
        }

        $session->set('cart', $cart);
    }

    public function recalc(int $id) {
        $session = $this->requestStack->getSession();
        $cart = $session->get('cart', []);

        if(isset($_POST)){
            foreach($_POST as $id => $quantity){
                $cart[$id] = $quantity;
            }
        } else {
            return false;
        }

        $session->set('cart', $cart);
    }


    public function remove(int $id) {
        $session = $this->requestStack->getSession();
        $cart = $session->get('cart', []);

        if(isset($cart[$id])){
            if($cart[$id] > 1){
                $cart[$id]--;
            } else {
                unset($cart[$id]);
            }
        }

        $session->set('cart', $cart);
    }

    public function delete(int $id){
        $session = $this->requestStack->getSession();
        $cart = $session->get('cart', []);

        if(isset($cart[$id])){
            unset($cart[$id]);
        }

        $session->set('cart', $cart);
    }

    public function getFullCart() : array{
        $cart = $this->requestStack->getSession()->get('cart', []);
        
        $cartWithData = [];

        foreach($cart as $id => $quantity){
            $cartWithData[] = [
                'product' => $this->productRepository->find($id),
                'quantity' => $quantity
            ];
        }

        return $cartWithData;
    }

    public function getTotal(): float{
        $total = 0;

        // dd($this->requestStack->getSession()->get('cart'));
        
        foreach($this->getFullCart() as $item){
            $total += $item['product']->getPrice() * $item['quantity'];
        }

        return $total;
    }

}