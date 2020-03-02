<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class NavBarController extends AbstractController
{


    /**
     * @Route("/pageCategory/{id}", name="pageCategory")
     */
   public function pageCategory($id, ProductRepository $repositery)
   {

    
    $products = $repositery->findBy([
        'category' => $id
    ]);
    
     return $this->render('nav_bar/index.html.twig', [
            'products' => $products,
        ]);


   }
}
