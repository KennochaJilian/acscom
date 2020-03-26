<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ApiProductController extends AbstractController
{
    /**
     * @Route("/api/product/{id}", name="api_product")
     */
    public function index($id, ProductRepository $productRepository)
    {
        
        $product = $productRepository->find($id);
        
        return $this->json($product, 200,[], ['groups' =>'product:read']); 

    }
}
