<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController2Controller extends AbstractController
{
    #[Route('/product/controller2', name: 'app_product_controller2')]
    public function detail(): Response
    {
        return $this->render('product_controller2/detail.html.twig', [
            'controller_name' => 'ProductController2Controller',
        ]);
    }
}
