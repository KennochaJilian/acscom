<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\Category;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiProductController extends AbstractController
{
    /**
     * @Route("/api/product", name="api_product_index", methods={"GET"})
     */
    public function index(ProductRepository $productRepository)
    {

        return $this->json($productRepository->findAll(), 200, [], ['groups' => 'product:read']);
    }

    /**
     * @Route("/api/product", name="api_product_store", methods={"POST"})
     */
    public function store(Request $request, SerializerInterface $serializer, EntityManagerInterface $manager)
    {
        $getproductjson = $request->getcontent();

        $product = $serializer->deserialize($getproductjson, Product::class, 'json');

        $manager->persist($product);
        $manager->flush();

        return $this->json(['code' => 200, 'message' => "Produit retiré "], 200);
    }
}
