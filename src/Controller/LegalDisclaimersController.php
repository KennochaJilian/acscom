<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class LegalDisclaimersController extends AbstractController
{
    /**
     * @Route("/legal/disclaimers", name="legal_disclaimers")
     */
    public function index()
    {
        return $this->render('legal_disclaimers/index.html.twig', [
            'controller_name' => 'LegalDisclaimersController',
        ]);
    }
}
