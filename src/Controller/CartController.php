<?php

namespace App\Controller;

use App\Entity\DiscountTicket;
use App\Form\DiscountTicketType;
use App\Repository\DiscountTicketRepository;
use App\Service\Cart\CartService;
use App\Repository\UserRepository;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\Session;

class CartController extends AbstractController
{
    /**
     * @Route("/panier", name="cart_index")
     */
    public function index(CartService $cartService, UserRepository $userRepository,Security $security, Request $request, DiscountTicketRepository $DiscountRepo, Session $session){
        
        if(!isset($reducedAmount)){
            $reducedAmount = $session->get('discount', null); 
        }
        
        $DiscountTicket = new DiscountTicket(); 

        $form = $this->createForm(DiscountTicketType::class, $DiscountTicket);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $DiscountTicket = $DiscountRepo->findOneby(['codeContent' => $DiscountTicket->getCodeContent()]);
            
            $reducedAmount = $cartService->addDiscount($DiscountTicket->getPercentageDiscount()); 
            

        }


        
        
        return $this->render('cart/index.html.twig', [
            'items' => $cartService->getFullCart(),
            'total' => $cartService->getTotal(),
            'form' => $form->createView(), 
            'reducedAmount' => $reducedAmount
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

    public function modifQuantity($id, CartService $cartService, Session $session){

        $cartService->modifQuantity($id,intval($_POST['quantity']));
        $discount = $session->get('discountPromo', null); 
        if ($discount != null){
            $cartService->addDiscount($discount); 
        }

        return $this->redirectToRoute("cart_index");
    }

}
