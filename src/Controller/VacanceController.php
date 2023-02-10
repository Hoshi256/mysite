<?php

namespace App\Controller;

use App\Entity\Vacance;
use App\Form\VacanceType;
use App\Repository\VacanceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/vacance')]
class VacanceController extends AbstractController
{
    #[Route('/', name: 'app_vacance_index', methods: ['GET'])]
    public function index(VacanceRepository $vacanceRepository): Response
    {
        return $this->render('vacance/index.html.twig', [
            'vacances' => $vacanceRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_vacance_new', methods: ['GET', 'POST'])]
    public function new(Request $request, VacanceRepository $vacanceRepository): Response
    {
        $vacance = new Vacance();
        $form = $this->createForm(VacanceType::class, $vacance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $vacanceRepository->save($vacance, true);

            return $this->redirectToRoute('app_vacance_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('vacance/new.html.twig', [
            'vacance' => $vacance,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_vacance_show', methods: ['GET'])]
    public function show(Vacance $vacance): Response
    {
        return $this->render('vacance/show.html.twig', [
            'vacance' => $vacance,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_vacance_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Vacance $vacance, VacanceRepository $vacanceRepository): Response
    {
        $form = $this->createForm(VacanceType::class, $vacance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $vacanceRepository->save($vacance, true);

            return $this->redirectToRoute('app_vacance_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('vacance/edit.html.twig', [
            'vacance' => $vacance,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_vacance_delete', methods: ['POST'])]
    public function delete(Request $request, Vacance $vacance, VacanceRepository $vacanceRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$vacance->getId(), $request->request->get('_token'))) {
            $vacanceRepository->remove($vacance, true);
        }

        return $this->redirectToRoute('app_vacance_index', [], Response::HTTP_SEE_OTHER);
    }
}
