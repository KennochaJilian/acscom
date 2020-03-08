<?php 

namespace App\Service\PayPal;

use PayPal\Api\Amount;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use \PayPal\Rest\ApiContext; 
use \PayPal\Auth\OAuthTokenCredential;
use PayPal\Exception\PayPalConnectionException;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class PayPalService
{

    private $apiContext;
    private $router;
    private $ex;   

    public function __construct(UrlGeneratorInterface $router)
    {
        $this->apiContext = new ApiContext(
            new OAuthTokenCredential(
                'ARyrkxiA8B1WsWflsk0l-Pk-GbqkrTXxuUAW8RyZTBc60g0a-87eKU6Ljqw43KK4O4V6VVtGB8P1imFX',     // ClientID
                'EDW8Jao0P-CPXNwR-JzPRz5yRUVEED8U7otjknkeH37rSLga6Eq-ce8x7GCRrcZSAS1Ro_VLF-6V3aaZ'      // ClientSecret
            )
    );
        $this->router = $router; 
   
    }

        public function createNewPayement ($orderAmount)
        {
            $payer = new Payer(); 
            $payer->setPaymentMethod('paypal'); 

            $amount = new Amount(); 
            $amount->setTotal($orderAmount); 
            $amount->setCurrency('EUR');
            
            $transaction = new Transaction(); 
            $transaction->setAmount($amount); 

            
            $redirectUrls = new RedirectUrls(); 
            $redirectUrls-> setReturnUrl($this->router->generate('homepage', [], UrlGeneratorInterface::ABSOLUTE_URL))
                        ->setCancelUrl($this->router->generate('order', [], UrlGeneratorInterface::ABSOLUTE_URL)); 

            $payment = new Payment(); 
            $payment->setIntent('sale')
                    ->setPayer($payer)
                    ->setTransactions(array($transaction))
                    ->setRedirectUrls($redirectUrls); 


            try {
                $payment->create($this->apiContext);
                echo $payment;
                echo "\n\nRedirect user to approval_url: " . $payment->getApprovalLink() . "\n";
            }
            catch (\PayPal\Exception\PayPalConnectionException $ex) {
                // This will print the detailed information on the exception.
                //REALLY HELPFUL FOR DEBUGGING
                echo $this->ex->getData();
            }
            



        
}  
} 
