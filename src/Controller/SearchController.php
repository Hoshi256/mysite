<?php

namespace App\Controller;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    #[Route('/search', name: 'app_search')]
    public function index(Request $request): Response
    {
        $form = $this->createForm(SearchType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            return $this->redirectToRoute('app_search_results', ['search-term' => $data['searchTerm']]);
        }

        return $this->render('search/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    
    #[Route('/search/results', name: 'app_search_results')]
    public function search(Request $request, EntityManagerInterface $entityManager): Response
    {
        $searchTerm = $request->query->get('search-term');

        $repository = $entityManager->getRepository(Product::class);
        $results = $repository->createQueryBuilder('p')
            ->where('p.name LIKE :searchTerm')
            ->setParameter('searchTerm', '%' . $searchTerm . '%')
            ->getQuery()
            ->getResult();

        return $this->render('search/results.html.twig', [
            'searchTerm' => $searchTerm,
            'results' => $results,
        ]);
    }
}

