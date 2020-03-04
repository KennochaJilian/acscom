<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Adress;
use App\Entity\Order;
use App\Form\AddressType;
use App\Repository\AdressRepository;
use App\Repository\DeliveryOptionsRepository;
use App\Repository\UserRepository;
use App\Service\Cart\CartService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class OrderController extends AbstractController
{
    /**
     * @Route("/order", name="order")
     */
    public function index(AdressRepository $repoAddresse, Request $request, UserRepository $repositery, CartService $cartService)
    {
        $addressUser = $repoAddresse->findBy([
            'user' => $this->getUser()->getId()
        ]);
        $manager = $this->getDoctrine()->getManager();

        $address = new Adress();
        $form = $this->createForm(AddressType::class, $address);
        $form->handleRequest($request); 

        if($form->isSubmitted() && $form->isValid()){
        
            $user = $repositery->findBy([
                'id' => $this->getUser()->getId()
            ]);

            $address-> setUser($user[0]);
            $manager->persist($address); 
            $manager->flush();
            return $this->redirectToRoute('order');
        }

        return $this->render('order/index.html.twig', [
            'addressUser' => $addressUser,
            'form' => $form->createView(), 
            'editMode' => $address->getId()!==null,
            'orderMode' => true,
            'items' => $cartService->getFullCart(),
            'total' => $cartService->getTotal()  
        ]);
    }

    /**
     * @Route("/order/check", name="order_check")
     */

    public function checkOrder(UserRepository $repositery,CartService $cartService, AdressRepository $repoAddresse, DeliveryOptionsRepository $repoDelivery,SessionInterface $session)
    {
        $manager = $this->getDoctrine()->getManager();
        $user = $repositery->findBy([
            'id' => $this->getUser()->getId()
        ]);

        $addressUser = $session->get('adressUser'); 

        $deliveryOptions = $repoDelivery->findBy([
            'id' => 1
        ]); 
        $order = new Order; 
        $order->setOrderDate(new \DateTime());
        $order->setOptionGift(false); 
        $order->setDeliveryOption($deliveryOptions[0]);
        $order->setOrderPriceTotal($cartService->getTotal()); 
        $order->setUser($user[0]); 
        $order->setDeliveryAddress($addressUser);
        $order->setFacturationAddress($addressUser);
       
        foreach($cartService->getFullCart() as $product)
        {
            $order->addProduct($product['product']);   
        }
        
        $manager->persist($order); 
        $manager->flush();
        $cartService->removeAllCart(); 
         

        return $this->render('order/check_order.html.twig', [
            
        ]);

    }

    /**
     * @Route("/order/useAddress/{id}", name="order_useAddress")
     */

     public function addAdress($id, AdressRepository $repoAddresse,SessionInterface $session){

        $address = $repoAddresse->find($id); 
        $session->set('adressUser', $address);
        return $this->redirectToRoute('order');
     }

     
    /**
     * @Route("/order/optionGift", name="order_optionGift")
     */

    public function optionGift(SessionInterface $session){

        $session->set('optionGift', true);
        return $this->redirectToRoute('order');
     }


}
