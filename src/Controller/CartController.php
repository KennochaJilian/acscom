<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use App\Service\Cart\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

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
    public function add($id, CartService $cartService, ProductRepository $repo){

        $cartService->add($id);
        $product = $repo->find($id); 

        return $this->json(['code' => 200, 'message' => $product->getName()], 200);
        //return $this->redirectToRoute("cart_index");
    }

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

        $cartService->modifQuantity($id);
        return $this->redirectToRoute("cart_index");
    }

}
