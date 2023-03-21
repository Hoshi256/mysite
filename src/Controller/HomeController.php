<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Stripe\Price;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(ProductRepository $productRepository): Response
    {
                $product = $productRepository->findAll();

        return $this->render('home/index.html.twig', [
                'product' => $product,

        ]);
    }

    


}
