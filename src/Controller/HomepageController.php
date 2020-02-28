<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Product;
use App\Repository\ProductRepository;

class HomepageController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index(ProductRepository $repositery)
    {
       
        $products = $repositery->findSearch(); 
             
        return $this->render('homepage/index.html.twig', [
            'products' => $products,
        ]);
    }


    
}
