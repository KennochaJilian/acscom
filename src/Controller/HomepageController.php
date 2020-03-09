<?php

namespace App\Controller;

use App\Data\Search;
use App\Entity\Product;
use App\Data\SearchData;
use App\Form\SearchForm;
use App\Form\SearchType;
use App\Entity\OrdersProducts;
use App\Service\Cart\CartService;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class HomepageController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */

    public function index(ProductRepository $repositery, Request $request, AuthenticationUtils $authenticationUtils)
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

    /**
     * 
     *@Route ("/pageproduct/{id}", name="pageProduct")
     */
    public function _product($id, CartService $cartService, Request $request){

        $repo = $this->getDoctrine()->getRepository(Product::class);

        
        $form = $this->createFormBuilder()
            ->add('quantity', NumberType::class)
            ->add('Ajouter au panier', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $quantity = intval($_POST['form']['quantity']);
            $cartService->modifQuantity($id,$quantity);
            return $this->redirectToRoute("homepage"); 
        }

        $product = $repo->find($id);
        return $this->render('product/_product.html.twig', [
        'product' => $product,
        'form' => $form->createView()
        ]);
    }
    
}
