<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ResettingType;
use App\Form\RegistrationType;

use App\Service\mail\MailService;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\HttpFoundation\Session\Session;

use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

class SecurityController extends AbstractController
{


    /**
    * @Route("/inscription", name="security_registration") 
    */  
    public function registration(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $manager = $this->getDoctrine()->getManager();

        $user = new User(); 

        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request); 

        if($form->isSubmitted() && $form->isValid()){

            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash); 
            $manager->persist($user); 
            $manager->flush();

            $this->addFlash(
                'notice', 
                'Votre compte a bien été créé !'
            ); 
            return $this->redirectToRoute('security_login'); 
        }

        return $this->render('security/registration.html.twig', [
            'form'=> $form->createView()
        ]);
        
    }

    /**
    * @Route("/login", name="security_login") 
    */

    public function login(AuthenticationUtils $authenticationUtils)
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        return $this->render('security/login.html.twig',[
            'error' => $error
        ]);

    }





    /**
    * @Route("/logout", name="security_logout") 
    */

    public function logout(){}

    /**
    * @Route("/forgottenPassword", name="security_forgottenPass") 
    */

    public function forgottenPassword(Request $request, MailService $mailer, TokenGeneratorInterface $tokenGenerator, UserRepository $repositery){

        

        $form = $this->createFormBuilder()
        ->add('email', EmailType::class, [
            'constraints' => [
                new Email(),
                new NotBlank()
            ]
        ])
        ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            

            $manager = $this->getDoctrine()->getManager();
            $user = $repositery->findBy([
                'email' => $form->getData()['email']
            ]);
            
            if (empty($user)) {
            
            // $request->getSession()->getFlashBag()->add('warning', "Cet email n'existe pas."); 
            return $this->redirectToRoute("security_forgottenPass");

            } 
            $user = $user[0]; 

            $user->setToken($tokenGenerator->generateToken());
            $user->setPasswordRequestedAt(new \Datetime());
            $manager->flush(); 


            $mailer->recreatePass($user); 

        }



        return $this->render('security/forgottenPass.html.twig', [
            'form' => $form->createView()
        ]);
    }

    private function isRequestInTime(\Datetime $passwordRequestedAt = null)
    {
        if ($passwordRequestedAt === null)
        {
            return false;        
        }
        
        $now = new \DateTime();
        $interval = $now->getTimestamp() - $passwordRequestedAt->getTimestamp();

        $daySeconds = 60 * 10;
        $response = $interval > $daySeconds ? false : $reponse = true;
        return $response;
    }

    /**
    *@Route("/{id}/{token}", name="resetting")
    */

    public function resetting(User $user, $token, Request $request, UserPasswordEncoderInterface $encoder){
        
        if ($user->getToken() === null || $token !== $user->getToken() || !$this->isRequestInTime($user->getPasswordRequestedAt()))
        {
            throw new AccessDeniedHttpException();
        }

        $form = $this->createForm(ResettingType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $password = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);

            // réinitialisation du token à null pour qu'il ne soit plus réutilisable
            $user->setToken(null);
            $user->setPasswordRequestedAt(null);

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($user);
            $manager->flush();


            return $this->redirectToRoute('security_login');

        }

    return $this->render('security/resetPass.html.twig',[
        'form'=> $form->createView()
    ]);
    }

}