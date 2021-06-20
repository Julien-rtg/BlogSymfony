<?php

namespace App\Service;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


class CartService {

    protected $session;
    protected $productRepository;

    public function __construct(SessionInterface $session, ProductRepository $productRepository){
        $this->session = $session;
        $this->productRepository = $productRepository;
    }

    public function add(int $id){
        $cart = $this->session->get('cart', []);

        if(isset($cart[$id])){
            $cart[$id]++;
        } else {
            $cart[$id] = 1;
        }

        $this->session->set('cart', $cart);
    }

    public function remove(int $id) {
        $cart = $this->session->get('cart', []);

        if(isset($cart[$id])){
            if($cart[$id] > 1){
                $cart[$id]--;
            } else {
                unset($cart[$id]);
            }
        }

        $this->session->set('cart', $cart);
    }

    public function delete(int $id){
        $cart = $this->session->get('cart', []);

        if(isset($cart[$id])){
            unset($cart[$id]);
        }

        $this->session->set('cart', $cart);
    }

    public function getFullCart() : array{
        $cart = $this->session->get('cart', []);
        
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

        foreach($this->getFullCart() as $item){
            $total += $item['product']->getPrice() * $item['quantity'];
        }

        return $total;
    }

}