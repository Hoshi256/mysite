<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\Category1Type;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

#[Route('/crud')]
class CrudController extends AbstractController
{
    #[Route('/', name: 'app_crud_index', methods: ['GET'])]
    public function index(CategoryRepository $categoryRepository ): Response
    {
        return $this->render('crud/index.html.twig', [
            'categories' => $categoryRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_crud_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CategoryRepository $categoryRepository, SluggerInterface $slugger): Response
    {
        $category = new Category();
        $form = $this->createForm(Category1Type::class, $category);
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
                       $category->setImage($newFileName);

                      //  $category -> setImage(
                      //   new File($this->getParameter('images_directory').'/'.$category->getImage())
                      // );
                     }


            $categoryRepository->save($category, true);

            return $this->redirectToRoute('app_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('crud/new.html.twig', [
            'category' => $category,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_crud_show', methods: ['GET'])]
    public function show(Category $category): Response
    {
        return $this->render('crud/show.html.twig', [
            'category' => $category,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_crud_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Category $category, CategoryRepository $categoryRepository, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(Category1Type::class, $category);
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
                       $category->setImage($newFileName);

                      //  $category -> setImage(
                      //   new File($this->getParameter('images_directory').'/'.$category->getImage())
                      // );
                     }

            $categoryRepository->save($category, true);

            return $this->redirectToRoute('app_crud_index', [], Response::HTTP_SEE_OTHER);
        }
       
        return $this->renderForm('crud/edit.html.twig', [
            'category' => $category,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_crud_delete', methods: ['POST'])]
    public function delete(Request $request, Category $category, CategoryRepository $categoryRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$category->getId(), $request->request->get('_token'))) {
            $categoryRepository->remove($category, true);
        }

        return $this->redirectToRoute('app_crud_index', [], Response::HTTP_SEE_OTHER);
    }
}
