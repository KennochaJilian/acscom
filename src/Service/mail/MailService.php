<?php

namespace App\Service\mail;

use Symfony\Component\DependencyInjection\ContainerInterface;

class MailService{

    protected $mailer; 
    protected $templating; 
    public function __construct( \Swift_Mailer $mailer, \Twig\Environment $templating )
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
    }

    public function orderConfirmed($userMail, $userName, $cart, $cartTotal){
        $message = (new \Swift_Message('Commande validée !'))
            ->setFrom('commande@acs.com')
            ->setTo($userMail)
            ->setBody(
                $this->templating->render(
                    'emails/orderConfirmed.html.twig',[
                        'name' =>  $userName,
                        'cart' => $cart,
                        'total' => $cartTotal
                    ]
                    ),
                'text/html'
            );
        
        $this->mailer->send($message); 
    }

    public function recreatePass($user){

        $message = (new \Swift_Message('Mot de passe oublié !'))
            ->setFrom('motdepasseoublie@acs.com')
            ->setTo($user->getEmail())
            ->setBody(
                $this->templating->render(
                    'emails/recreatePass.html.twig',[
                        'user' => $user
                    ]
                )
            );
        $this->mailer->send($message);
    }


















}