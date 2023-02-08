<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{
    #[Route('/product/add', name: 'app_add_product')]
    public function add(Request $request, EntityManagerInterface $em):Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form ->isValid()) {
            $em->persist($product);
            $em->flush();
            $this->addFlash('succes', 'produit inseré avec succes');
            return $this ->redirectToRoute('app_home');
        }
        return $this->render('product/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }


            // edit product


     #[Route('/product/edit/{id}', name: 'app_edit_product')]
    public function app_edit_product(Request $request, EntityManagerInterface $em, $id):Response
    {
        $product = $em->getRepository('App\Entity\Product')->find($id);
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form ->isValid()) {
            $em->persist($product);
            $em->flush();
            $this->addFlash('succes', 'produit edite avec succes');
            return $this ->redirectToRoute('app_home');
        }
        return $this->render('product/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
