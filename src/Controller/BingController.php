<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BingController extends AbstractController
{
    #[Route('/bing', name: 'app_bing')]
   public function index(): Response
    {
        $apiKey = 'AhmZHpArEeL_jrnzVqg3Edv4qDGlqZeoIJ-I7yM8u1Ym3fBA54gAxc0_PCg3UmGc';
        $mapOptions = [
            'center' => [
                'latitude' => 43.561779,
                'longitude' => 3.797811
,
            ],
            'zoom' => 10,
        ];

        return $this->render('bing/index.html.twig', [
            'apiKey' => $apiKey,
            'mapOptions' => $mapOptions,
        ]);
    }
}
