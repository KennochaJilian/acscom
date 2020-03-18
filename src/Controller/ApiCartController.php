<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use App\Service\Cart\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ApiCartController extends AbstractController
{
    /**
     * @Route("/api/cart", name="api_cart_index", methods={"GET"})
     */
    public function index(CartService $cartService, ProductRepository $productRepository)
    {
      
        $productFromCart = $cartService->getFullCart(); 
        $productsAssociated = []; 
        foreach($productFromCart as $product){
            foreach($productRepository->getProductAssociated( $product['product']->getId()) as $productTest ){
                $productsAssociated[] = $productTest;
                }

        }
        $products = array(
            "productFromCart" => $productFromCart, 
            "productsAssociated" => $productsAssociated
        ); 


        return $this->json($products, 200, [], ['groups' => 'product:read']); 

    }

    /**
     * @Route("/api/cart_add/{id}", name="api_cart_add", methods={"GET"})
     */

    public function add($id, CartService $cartService)
    {

        
        $cartService->add($id);

        return $this->json(['code' => 200, 'message' => "Produit ajouté "], 200);
    }

     /**
     * @Route("/api/cart_remove/{id}", name="api_cart_remove", methods={"GET"})
     */

    public function remove($id, CartService $cartService)
    {

        
        $cartService->remove($id);

        return $this->json(['code' => 200, 'message' => "Produit retiré "], 200);
    }

    /**
     * @Route("/api/cart_modifQuantity/{id}", name="api_cart_modif", methods={"POST"})
     */

    public function modifQuantity($id, CartService $cartService, Request $request)
    {
        $jsonReçu = $request->getContent();

        $cartService->modifQuantity($id,json_decode($jsonReçu)->quantity);

        return $this->json(['code' => 200, 'message' => "Quantite modifie"], 200);
    }

}
