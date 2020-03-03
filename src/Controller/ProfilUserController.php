<?php

namespace App\Controller;

use App\Entity\Adress;
use App\Form\AddressType;
use App\Repository\AdressRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class ProfilUserController extends AbstractController
{
    /**
     * @Route("/profil/user", name="profil_user")
     */

    public function index(AdressRepository $repoAddresse)
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_USER')) {
            // Sinon on déclenche une exception « Accès interdit »
            throw new AccessDeniedException('Accès limité aux auteurs.');
        }

        $addressUser = $repoAddresse->findBy([
            'user' => $this->getUser()->getId()
        ]);
        

        return $this->render('profil_user/index.html.twig', [
            'addressUser' => $addressUser 
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
        
        $manager->remove($addressToRemove); 
        $manager->flush();

        return $this->redirectToRoute('profil_user');

    }
}