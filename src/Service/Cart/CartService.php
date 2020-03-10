<?php

namespace App\Service\Cart;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Request;

class CartService{

    protected $session;
    protected $productRepository;

    public function __construct(SessionInterface $session, ProductRepository $productRepository){

        $this->session = $session;
        $this->productRepository = $productRepository;
    }

    public function add(int $id){
        
        $panier = $this->session->get('panier', []);

        if(!empty($panier[$id])){
            $panier[$id]++;
        } else{
            $panier[$id] = 1;
        }

        $this->session->set('panier', $panier);
    }
//////////////////////////////////////////////////////////////////////////////////////////////
    public function addFromProduct(int $id){
        // $panier = $this->session->get('panier', []);
        // // $quantity = $this->session->get('quantity');
       

        // if(!empty($quantity)){ 
        //     dd("coucou je passe dans le if");
        //     if(!empty($panier[$id])){
        //         dd("coucou je passe dans le if");
        //         // $quantity = $_POST['quantity']; 
        //         //$panier[$id] = $quantity ++;
                
        //     } else{
        //         $panier[$id] = $quantity +1;
        //     }
        // }
        
        // $this->session->set('panier', $panier);
    }
/////////////////////////////////////////////////////////////////////////////////////////////////
    public function remove(int $id){

        $panier = $this->session->get('panier', []);

        if(!empty($panier[$id])) {
            unset($panier[$id]);
            $this->session->set('discount', []);
            $this->session->set('discountPromo', []);

        }
        $this->session->set('panier', $panier);
    
    }

    public function getFullCart() : array {

        $panier = $this->session->get('panier', []);
        
        $panierWithData = [];
        
        foreach($panier as $id => $quantity){
            $panierWithData[] = [
                'product' => $this->productRepository->find($id),
                'quantity' => $quantity
            ];
        }
        
        return $panierWithData;
    }

    public function getTotal()  : float {

        $total = 0;

        foreach($this->getFullCart() as $item){
            $total += $item['product']->getPrice() * $item['quantity'];
        }

        return $total;
    }

    public function modifQuantity(int $id, int $quantity){
        $panier = $this->session->get('panier',[]); 
        
        //$panier[$id] = $_POST['quantity'];
        $panier[$id] = $quantity;
        $this->session->set('panier', $panier);
    }

    public function removeAllCart(){ 
    $this->session->set('panier', []);
    $this->session->set('discount', []);
    $this->session->set('discountPromo', []);
    }

    public function addDiscount($discount){
        $total = $this->getTotal();
        $total = round($total-($total * $discount), 2);
        $this->session->set('discount', $total );
        $this->session->set('discountPromo', $discount );
        return $total;
    }

}