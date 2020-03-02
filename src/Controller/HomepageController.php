<?php

namespace App\Controller;

use App\Data\SearchData;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Product;
use App\Form\SearchForm;
use App\Repository\ProductRepository;
use App\Repository\TagRepository;
use Symfony\Component\HttpFoundation\Request;

class HomepageController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */

    public function index(ProductRepository $repositery, Request $request, TagRepository $tagRepo)
    {
        $data =new SearchData(); 
        $form = $this->createForm(SearchForm::class, $data);
        $form->handleRequest($request); 

        $tags = $tagRepo->findAll();          

        $products = $repositery->findSearch($data);

        return $this->render('homepage/index.html.twig', [
            'products' => $products,
            'form' => $form->createView()
        ]);
    }


    
}
