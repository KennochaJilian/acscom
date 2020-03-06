<?php

namespace App\Controller;

use App\Service\Cart\CartService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
    /**
     * @Route("/panier", name="cart_index")
     */
    public function index(CartService $cartService){
        
        return $this->render('cart/index.html.twig', [
            'items' => $cartService->getFullCart(),
            'total' => $cartService->getTotal()
        ]);
    }
        
    /**
     * @Route("/panier/add/{id}", name="cart_add")
     */
    public function add($id, CartService $cartService){

        $cartService->add($id);

        return $this->redirectToRoute("cart_index");
    }
/////////////////////////////////////////////////////////////////////////////////
    /**
     * @Route("/panier/addFromProduct/{id}", name="cart_addFromProduct")
     */
    public function addFromProduct($id, CartService $cartService){
        
        
        //$cartService->addFromProduct($id);

        return $this->redirectToRoute("cart_index");
    }
//////////////////////////////////////////////////////////////////////////////////
    /**
     * @Route("/panier/remove/{id}", name="cart_remove")
     */
    public function remove($id, CartService $cartService){

        $cartService->remove($id);

        return $this->redirectToRoute("cart_index");
    }

    /**
     * @Route("/panier/modifQuantity/{id}", name="cart_modif")
     */

    public function modifQuantity($id, CartService $cartService){
        $cartService->modifQuantity($id,intval($_POST['quantity']));
        
        return $this->redirectToRoute("cart_index");
    }

}
