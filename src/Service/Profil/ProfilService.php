<?php 

namespace App\Service\Profil;

use App\Repository\OrderRepository;
use App\Repository\AdressRepository;
use App\Repository\ProductRepository;
use App\Repository\OrdersProductsRepository;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Session\Session;

class ProfilService
{
    protected $security;

    protected $repoAddress;
    protected $orderRepo;
    protected $productRepository;
    protected $OrderProductRepo; 

    public function __construct(OrderRepository $orderRepo, OrdersProductsRepository $productFromOrderRepo, ProductRepository $productRepo, AdressRepository $repoAddresse)

    {
        $this->repoAddress = $repoAddresse; 
        $this->orderRepo = $orderRepo; 
        $this->productRepository= $productRepo; 
        $this->OrderProductRepo = $productFromOrderRepo; 
        
        
    }

    public function getAddress($user)
    {
        return  $this->repoAddress->findBy([
            'user' => $user
        ]);
    }

    public function getOrders($user)
    {
        return $this->orderRepo->findBy([
            'user' =>$user->getId()
        ]); 
    }

   

}
