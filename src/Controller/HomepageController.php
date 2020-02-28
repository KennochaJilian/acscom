<?php

namespace App\Controller;

use App\Data\SearchData;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Product;
use App\Form\SearchForm;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;

class HomepageController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */

    public function index(ProductRepository $repositery, Request $request)
    {
        $data =new SearchData(); 
        $form = $this->createForm(SearchForm::class, $data);
        $form->handleRequest($request); 

        $products = $repositery->findSearch($data);
        //dd($products); 

        return $this->render('homepage/index.html.twig', [
            'products' => $products,
            'form' => $form->createView()
        ]);
    }


    
}
