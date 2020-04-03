<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Comment;
use App\Entity\Product;
use App\Form\CommentType;
use App\Entity\OrdersProducts;
use App\Service\Cart\CartService;
use App\Service\Comment\CommentOptions;
use App\Repository\CommentRepository;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class PageProductController extends AbstractController
{
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
            ->add('Ajouter', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $quantity = intval($_POST['form']['quantity']);
            $cartService->modifQuantity($id, $quantity);
            return $this->redirectToRoute("homepage"); 
        }

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
            return $this->redirectToRoute("pageProduct", ['id' => $id]);
        }

        $commentaries = $repo_comment->findBy([
            "product" =>$product
        ]);
        $user = $security->getUser();
        $productsAssociated = $repo_product->getProductAssociated($id);
//////////////////////////////////////////////Fin Commentaire////////////////////////////////////////////////
        
        return $this->render('product/_product.html.twig', [
            'product' => $product,
            'commentaries' => $commentaries,
            "user" => $user,
            'form' => $form->createView(),
            'form_comment' => $form_comment->createView(),
            'productsAssociated' => $productsAssociated
        ]);
    }



    /**
    * 
    *@Route ("/pageproduct/{id}/comment/{idcomment}/delete", name="delete_comment")
    *@Method({"DELETE"})
    */

    public function deleteComment(int $id, int $idcomment){

        $manager = $this->getDoctrine()->getManager();

        $commentToDelete = $manager
            ->getRepository(Comment::class)
            ->find($idcomment);

        $manager->remove($commentToDelete);
        $manager->flush();

        // $response = new Response();
        // $response->send();

        return $this->redirectToRoute("pageProduct", ['id' => $id]);
    }

    /**
    * 
    *@Route ("/pageproduct/{id}/comment/{idcomment}/edit", name="edit_comment")
    *
    */

    public function editComment(int $id, int $idcomment, Request $request){
        
        $manager = $this->getDoctrine()->getManager();
        $commentToEdit = $manager
            ->getRepository(Comment::class)
            ->find($idcomment);

        $form_comment = $this->createForm(CommentType::class, $commentToEdit);

        $form_comment->handleRequest($request);

        if($form_comment->isSubmitted() && $form_comment->isValid()){
            $manager->flush();
            return $this->redirectToRoute("pageProduct", ['id' => $id]);
        }
        
        return $this->render('product/_edit_comment.html.twig', [
            'form_comment' => $form_comment->createView(),
        ]);
    }
}
