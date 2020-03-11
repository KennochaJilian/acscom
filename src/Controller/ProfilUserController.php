<?php

namespace App\Controller;

use App\Entity\Adress;
use App\Entity\OrdersProducts;
use App\Form\AddressType;
use App\Form\ChangePassword;
use App\Form\UpdatePassType;
use App\Repository\UserRepository;
use App\Repository\OrderRepository;
use App\Repository\AdressRepository;
use App\Repository\OrdersProductsRepository;
use App\Repository\ProductRepository;
use App\Service\Profil\ProfilService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class ProfilUserController extends AbstractController
{
    /**
     * @Route("/profil/user", name="profil_user")
     */

    public function index(Request $request, UserPasswordEncoderInterface $encoder, ProfilService $profilService )
    {
        $user = $this->getUser(); 
        
        $addressUser = $profilService->getAddress($user);
        $ordersUser = $profilService->getOrders($user);
        $fidelityPoint = $user->getFidelityPoint();
        // Permet de à l'utilisateur de modifier son mot de passe depuis la vue du profil
        $manager = $this->getDoctrine()->getManager();
        $changePassword = new ChangePassword(); 
        $form = $this->createForm(UpdatePassType::class, $changePassword);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            

            $newpwd = $form->get('password')['first']->getData();

            $newEncodedPassword = $encoder->encodePassword($user, $newpwd);
            $user->setPassword($newEncodedPassword);

            $manager->flush();

            $this->addFlash(
                'notice', 
                'Le mot de passe a bien été modifié !'
            ); 
        
            return $this->redirectToRoute('profil_user');

        }



        return $this->render('profil_user/index.html.twig', [
            'addressUser' => $addressUser,
            'orderMode' => false, 
            'form' => $form->createView(), 
            'orders' => $ordersUser,
            'fidelityPoint' =>$fidelityPoint 
        ]);
    }

    /**
     * @Route("/profil/addAddress", name="profil_addAddress")
     * @Route("profil/edit/{id}", name="profil_updateAddress") 
     */
    
    public function addAddress(Adress $address = null, Request $request, UserRepository $repositery)
    {
        $manager = $this->getDoctrine()->getManager();

        if(!$address){
            $address = new Adress(); 
        }
        
        $form = $this->createForm(AddressType::class, $address);
    
        $form->handleRequest($request); 

        if($form->isSubmitted() && $form->isValid()){
        
            $user = $repositery->findBy([
                'id' => $this->getUser()->getId()
            ]);

            $address-> setUser($user[0]);
            $manager->persist($address); 
            $manager->flush();
            
            return $this->redirectToRoute('profil_user');
        
        }
        return $this->render('profil_user/update.html.twig', [
            'form' => $form->createView(), 
            'editMode' => $address->getId()!==null    
        ]);
    }

    /**
     * @Route("/profil/removeAddress/{id}", name="profil_rmAddress")
    */

    public function removeAddress($id, AdressRepository $repositery)
    {

        $manager = $this->getDoctrine()->getManager();

        $addressToRemove = $repositery->find($id); 
        $addressToRemove->setUser(null);
        $manager->persist($addressToRemove);
        $manager->flush();

        return $this->redirectToRoute('profil_user');

    }
}