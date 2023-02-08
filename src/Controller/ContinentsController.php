<?php

namespace App\Controller;

use App\Entity\Continents;
use App\Form\ContinentsType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContinentsController extends AbstractController
{
    #[Route('/continents', name: 'app_continents')]
    public function index(): Response
    {
        return $this->render('continents/index.html.twig', [
            'controller_name' => 'ContinentsController',
        ]);
    }


    
    #[Route('/continents/add', name: 'app_add_continents')]
    public function add(Request $request, EntityManagerInterface $em): Response
    {
        $continents = new Continents();
        $form = $this->createForm(ContinentsType::class, $continents);
        $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                       $em->persist($continents);      
                       $em->flush();         
                    $this->addFlash('success', 'Continent insérée avec succès');
                     return $this->redirectToRoute('app_home');         
                    } 
  return $this->render('continents/add.html.twig', [            
    'form' => $form->createView()         
]);
        
    }
}
