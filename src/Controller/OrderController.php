<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Adress;
use App\Entity\Order;
use App\Entity\OrdersProducts;
use App\Form\AddressType;
use App\Form\OrdersType; 
use App\Repository\AdressRepository;
use App\Repository\UserRepository;
use App\Service\Cart\CartService;
use App\Service\mail\MailService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class OrderController extends AbstractController
{
    /**
     * @Route("/order", name="order")
     */
    public function index(AdressRepository $repoAddresse, Request $request, UserRepository $repositery, CartService $cartService, MailService $mailService, Session $session)
    {   
        
        $reducedAmount = $session->get('discount', null); 
        $fidelityPointUsed = $session->get('fidelityPoint', 0);

        $user = $repositery->findBy([
            'id' => $this->getUser()->getId()
        ])[0];

        $addressUser = $repoAddresse->findBy([
            'user' => $this->getUser()->getId()
        ]);

        $manager = $this->getDoctrine()->getManager();

        $address = new Adress();
        $form = $this->createForm(AddressType::class, $address);
        $form->handleRequest($request); 

        if($form->isSubmitted() && $form->isValid()){
            
            $address-> setUser($user);
            $manager->persist($address); 
            $manager->flush();

            return $this->redirectToRoute('order');
        }
        
        $order = new Order;

    
        $formOrder = $this->createForm(OrdersType::class, $order); 
        $formOrder->handleRequest($request); 
        if($formOrder->isSubmitted() && $formOrder->isValid()){
            if($reducedAmount != null){
                $cartTotal = $reducedAmount;
            } else{
                $cartTotal = $cartService->getTotal();
            }
            //Gestion des points de fidélités
            
            $fidelityPoint = $user->getFidelityPoint() + (round($cartTotal/10,0, PHP_ROUND_HALF_DOWN)) - $fidelityPointUsed; 
            $user->setFidelityPoint($fidelityPoint);
            $manager->persist($user); 

           $cartValid = $cartService->getFullCart(); 
           
            $order->setOrderPriceTotal($cartTotal);
            $order->setUser($this->getUser()); 
            foreach($cartValid as $product)
            {
                $orderProduct = new OrdersProducts; 
                $manager->persist($orderProduct); 
                $orderProduct->setProduct($product['product']); 
                $orderProduct->setQuantity($product['quantity']); 
                $order->addOrdersProduct($orderProduct); 

            }
            $manager->persist($order); 
            $manager->flush();
            $mailService->orderConfirmed($user->getEmail(), $user->getUsername(), $cartValid, $cartTotal); 
            $cartService->removeAllCart();
            return $this->redirectToRoute('homepage');
        }

        return $this->render('order/index.html.twig', [
            'addressUser' => $addressUser,
            'form' => $form->createView(), 
            'formOrder' => $formOrder->createView(), 
            'editMode' => $address->getId()!==null,
            'orderMode' => true,
            'items' => $cartService->getFullCart(),
            'total' => $cartService->getTotal(),             
            'reducedAmount' => $reducedAmount  
        ]);
    }
}
