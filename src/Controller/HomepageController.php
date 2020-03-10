<?php

namespace App\Controller;

use App\Data\Search;
use App\Entity\Comment;
use App\Entity\Product;
use App\Data\SearchData;
use App\Form\SearchForm;
use App\Form\SearchType;
use App\Form\CommentType;
use App\Entity\OrdersProducts;
use App\Service\Cart\CartService;
use App\Repository\CommentRepository;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
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
    public function _product($id, CartService $cartService, Request $request, ProductRepository $repo_product, CommentRepository $repo_comment, Security $security){
        $product = $repo_product->find($id);
        $form = $this->createFormBuilder()
            ->add('quantity', NumberType::class, [
                'data' => '1'
            ])
            ->add('Ajouter au panier', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $quantity = intval($_POST['form']['quantity']);
            $cartService->modifQuantity($id, $quantity);
            return $this->redirectToRoute("homepage"); 
        }
        
        $product = $repo_product->find($id);
        $productsAssociated = $repo_product->getProductAssociated(16); 
      
        

///////////////////////////////////////Commentaire/////////////////////////////////////////////////////////
        $manager = $this->getDoctrine()->getManager();

        $comment = new Comment();

        $form_comment = $this->createForm(CommentType::class, $comment);

        $form_comment->handleRequest($request);

        if($form_comment->isSubmitted() && $form_comment->isValid()){
            $comment->setProduct($product);
            $comment->setCommentaryDate(new \DateTime());
            $comment->setUsername($security->getUser());
            $manager->persist($comment);
            $manager->flush();
        }

        $commentaries = $repo_comment->findBy([
            "product" =>$product
        ]);
//////////////////////////////////////////////Fin Commentaire////////////////////////////////////////////////
        
        return $this->render('product/_product.html.twig', [
        'product' => $product,
        'commentaries' => $commentaries,
        'form' => $form->createView(),
        'form_comment' => $form_comment->createView(),
        'productsAssociated' => $productsAssociated
        ]);
    }
}
