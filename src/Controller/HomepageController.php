<?php

namespace App\Controller;

use App\Data\Search;
use App\Entity\Product;
use App\Data\SearchData;
use App\Form\SearchForm;
use App\Form\SearchType;
use App\Entity\OrdersProducts;
use App\Service\Cart\CartService;
use App\Repository\CommentRepository;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomepageController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index(ProductRepository $repositery, Request $request)
    {
        $data =new SearchData(); 
        $form = $this->createForm(SearchForm::class, $data);

        if(!empty($_POST)){
            $data->q = $_POST['search']; 
        }
        $form->handleRequest($request); 
        $products = $repositery->findSearch($data);

        return $this->render('homepage/index.html.twig', [
            'products' => $products,
            'form' => $form->createView(),
        ]);
    }

}
