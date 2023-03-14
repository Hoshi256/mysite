<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Product;
use App\Form\CommentType;
use App\Form\Product1Type;
use App\Repository\CommentRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
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
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

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

        return $this->render('product_controller_crud/new.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }


#[Route('/{id}', name: 'app_product_controller_crud_show', methods: ['GET', 'POST'])]
public function show(Product $product, Request $request, ProductRepository $productRepository, CommentRepository $commentRepository, EntityManagerInterface $em, PaginatorInterface $paginator): Response
{
    $user = $this->getUser();

    $comment = new Comment();
    $form = $this->createForm(CommentType::class, $comment);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $comment = $form->getData();
        $comment->setUser($user);
        $comment->setProduct($product);

        try {
            $em->persist($comment);
            $em->flush();

            $this->addFlash('success', 'Your comment has been added successfully!');
        } catch (\Exception $e) {
            $this->addFlash('error', 'Failed to save comment: ' . $e->getMessage());
        }

        return $this->redirectToRoute('app_product_controller_crud_show', ['id' => $product->getId()]);
    }

    $comment = $commentRepository->findBy(['product' => $product]);

 $commentsQuery = $commentRepository->createQueryBuilder('c')
        ->where('c.product = :product')
        ->setParameter('product', $product)
        ->getQuery();

    $pagination = $paginator->paginate(
        $commentsQuery,
        $request->query->getInt('page', 1),
        8 // limit per page
    );
    

    return $this->render('product_controller_crud/show2.html.twig', [
        'product' => $product,
        'comments' => $pagination,

        'form' => $form->createView(),
    ]);
}


    #[Route('/{id}/edit', name: 'app_product_controller_crud_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Product $product, ProductRepository $productRepository): Response
    {   
                $this->denyAccessUnlessGranted('ROLE_ADMIN');

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
                $this->denyAccessUnlessGranted('ROLE_ADMIN');

        if ($this->isCsrfTokenValid('delete'.$product->getId(), $request->request->get('_token'))) {
            $productRepository->remove($product, true);
        }

        return $this->redirectToRoute('app_product_controller_crud_index', [], Response::HTTP_SEE_OTHER);
    }

       


}
