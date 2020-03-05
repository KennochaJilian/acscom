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
       $message = (new \Swift_Message('Hello Email'))
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


















}