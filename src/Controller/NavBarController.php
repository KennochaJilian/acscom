<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class NavBarController extends AbstractController
{


    /**
     * @Route("/pageCategory/{id}", name="pageCategory")
     */
   public function pageCategory($id, ProductRepository $repositery, CategoryRepository $categoryRepository)
   {

    
    $products = $repositery->findBy([
        'category' => $id
    ]);
    $nameCategory = $categoryRepository->findOneBy([
        'id' => $id 
    ])->getName(); 
    
     return $this->render('nav_bar/index.html.twig', [
            'products' => $products,
            'category' =>$nameCategory
        ]);


   }
}
