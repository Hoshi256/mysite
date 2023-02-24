<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\Product1Type;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

#[Route('/product/controller/crud')]
class ProductControllerCrudController extends AbstractController
{
    #[Route('/', name: 'app_product_controller_crud_index', methods: ['GET'])]
    public function index(ProductRepository $productRepository): Response
    {
        return $this->render('product_controller_crud/index2.html.twig', [
            'products' => $productRepository->findAll(),
        ]);
    }



    #[Route('/new', name: 'app_product_controller_crud_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ProductRepository $productRepository, SluggerInterface $slugger): Response
    {
        $product = new Product();
        $form = $this->createForm(Product1Type::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $Image = $form->get('image')->getData(); 
             if ($Image) {
                $originalFileName = pathinfo($Image->getClientOriginalName(), PATHINFO_FILENAME);
                 $safeFileName = $slugger->slug($originalFileName);
                 $newFileName = $safeFileName. '-'.uniqid(). '.'.$Image->guessExtension();
                try {
                   $Image->move(
                          $this->getParameter('images_directory'),
                          $newFileName

                        ); 
                } catch (FileException $e) {

                }
                $product->setImage($newFileName);
             }



            $productRepository->save($product, true);

            return $this->redirectToRoute('app_product_controller_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('product_controller_crud/new.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }




    #[Route('/{id}', name: 'app_product_controller_crud_show', methods: ['GET'])]
    public function show(Product $product): Response
    {
        return $this->render('product_controller_crud/show2.html.twig', [
            'product' => $product,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_product_controller_crud_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Product $product, ProductRepository $productRepository): Response
    {
        $form = $this->createForm(Product1Type::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $productRepository->save($product, true);

            return $this->redirectToRoute('app_product_controller_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('product_controller_crud/edit.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_product_controller_crud_delete', methods: ['POST'])]
    public function delete(Request $request, Product $product, ProductRepository $productRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$product->getId(), $request->request->get('_token'))) {
            $productRepository->remove($product, true);
        }

        return $this->redirectToRoute('app_product_controller_crud_index', [], Response::HTTP_SEE_OTHER);
    }
}
