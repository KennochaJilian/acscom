<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Contact;
use App\Entity\CategoryQuestions;
use App\Form\ContactType;

class ContactFormController extends AbstractController
{
    /**
     * @Route("/contact/form", name="contact_form")
     */
    public function form(Request $request)
    {
        $manager = $this->getDoctrine()->getManager();

        $contact = new Contact();
        
        $form = $this->createForm(ContactType::class, $contact);

        $form->handleRequest($request);

        
        
        if($form->isSubmitted() && $form->isValid()){

            $manager->persist($contact);
            $manager->flush();

            $this->addFlash(
                'notice', 
                'Le message a bien été envoyé, nous vous recontacterons dans les plus brefs delais !'
            ); 
            return $this->redirectToRoute('homepage');
        }

        return $this->render('contact_form/index.html.twig',[
            'contactForm' => $form->createView()
        ]);
    }
}
