<?php

namespace App\Controller;

use App\Data\SearchData;
use App\Form\SearchForm;
use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class NavBarController extends AbstractController
{


    /**
     * @Route("/pageCategory/{id}", name="pageCategory")
     */
    public function pageCategory($id, ProductRepository $repository, CategoryRepository $categoryRepository, Request $request)
    {

    $products = $repository->findBy([
        'category' => $id
    ]);
    $nameCategory = $categoryRepository->findOneBy([
        'id' => $id 
    ])->getName(); 

    
    $data =new SearchData(); 
    $form = $this->createForm(SearchForm::class, $data);
    if(!empty($_POST)){
        $data->max = $_POST['max']; 
        $data->min = $_POST['min'];
        $form->handleRequest($request); 
        $products = $repository->findbyCategory($data, $id);
        
    }
    
    

    
    return $this->render('nav_bar/index.html.twig', [
            'products' => $products,
            'category' =>$nameCategory,
            'form' => $form->createView()
        ]);


    }
}
