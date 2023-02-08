<?php

namespace App\Controller;

use App\Entity\Countries;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CountriesController extends AbstractController
{
    #[Route('/countries', name: 'app_countries')]
    public function index(): Response
    {
        return $this->render('countries/index.html.twig', [
            'controller_name' => 'CountriesController',
        ]);
    }

     #[Route('/countries/add', name: 'app_add_countries')]
    public function add(Request $request, EntityManagerInterface $em):Response
    {
        $countries = new Countries();
        $form = $this->createForm(CountriesType::class, $countries);
        $form->handleRequest($request);       
                 if ($form->isSubmitted() && $form->isValid()) {
                       $em->persist($countries);      
                       $em->flush();         
                    $this->addFlash('success', 'Countries insérée avec succès');
                     return $this->redirectToRoute('app_home');         } 
  return $this->render('countries/add.html.twig', [            
    'form' => $form->createView()         
]);
    }
}
