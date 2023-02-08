<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', 
        
        [
            'controller_name' => 'HomeController',
            'test' => "coucou",
            'products' => ["Samsung", "Apple", "LG"],

            'client' => ["nom" => "Doe", "prenom" => "john"],
            
             'users'=> [ ["nom" => "pitt", "prenom" => "brad"] ,
                        ["nom" => "clooney", "prenom" => "george"],
                        ["nom" => "statham", "prenom" => "jason"] ]    
             

        ]
    
    
    );
    }




    #[Route('/apihome', name: 'app_home2')]
    public function index2(): Response
    {
        return new JsonResponse( [
            'controller_name' => 'HomeController',
            'test' => "coucou",
            'products' => ["Samsung", "Apple", "LG"],

            'client' => ["nom" => "Doe", "prenom" => "john"],
            
             'users'=> [ ["nom" => "pitt", "prenom" => "brad"] ,
                        ["nom" => "clooney", "prenom" => "george"],
                        ["nom" => "statham", "prenom" => "jason"] ]    
             

        ]);
    }








    

    
}
