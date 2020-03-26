<?php

namespace App\Controller;

use App\Data\SearchData;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiHomepageController extends AbstractController
{
    /**
     * @Route("/api/homepage", name="api_homepage")
     */
    // Fonction pour l'API qui marche aussi bien en POST que en GET en fonction s'il souhaite afficher tous les produits ou seulement ceux issus d'une recherche
    public function index(ProductRepository $productRepository, Request $request)
    {
        $data = new SearchData(); 

        $products = $productRepository->findAll();
        
        // Check si l'utilisateur vient pour une recherche, ou pour un simple affichage
        if($_GET['q'] !== ""){
            $data->q = $_GET['q'];
            $products = $productRepository->findSearch($data); 

        }
        foreach($products as $product){
            $product->setImages("../../acscom/assets/images/" . $product->getImages());
        }
        
        return $this->json($products, 200,[], ['groups' =>'product:read']); 
    }
}
