<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;





class CategoryController extends AbstractController
{
    

    #[Route('/category/add', name: 'app_add_category')]     
    public function add(Request $request, EntityManagerInterface $em, SluggerInterface $slugger): Response     
    {   $category = new Category();       
        $form = $this->createForm(CategoryType::class, $category);    
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
                  //dd($Image);
                       $em->persist($category);      
                       $em->flush();         
                    $this->addFlash('success', 'Catégorie insérée avec succès');
                     return $this->redirectToRoute('app_crud_index');         
                    } 
  return $this->render('category/add.html.twig', [            
    'form' => $form->createView()         
                ]);     
    }


    //edit category

    #[Route('/category/edit/{id}', name: 'app_edit_category')]     
    public function app_edit_category(Request $request, EntityManagerInterface $em, $id): Response     

    {   
        $category = $em->getRepository('App\Entity\Category')->find($id);
        $form = $this->createForm(CategoryType::class, $category);    
        $form->handleRequest($request);       
                 if ($form->isSubmitted() && $form->isValid()) {
                       $em->persist($category);      
                       $em->flush();         
                    $this->addFlash('success', 'Catégorie editée avec succès');
                     return $this->redirectToRoute('app_home');         
                    } 
  return $this->render('category/edit.html.twig', [            
    'form' => $form->createView()         
                ]);     
    }

    
}
