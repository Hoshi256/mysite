<?php

namespace App\Controller;

use App\Entity\Oras;
use App\Form\OrasType;
use App\Repository\OrasRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/oras')]
class OrasController extends AbstractController
{
    #[Route('/', name: 'app_oras_index', methods: ['GET'])]
    public function index(OrasRepository $orasRepository): Response
    {
        return $this->render('oras/index.html.twig', [
            'oras' => $orasRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_oras_new', methods: ['GET', 'POST'])]
    public function new(Request $request, OrasRepository $orasRepository): Response
    {
        $ora = new Oras();
        $form = $this->createForm(OrasType::class, $ora);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $orasRepository->save($ora, true);

            return $this->redirectToRoute('app_oras_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('oras/new.html.twig', [
            'ora' => $ora,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_oras_show', methods: ['GET'])]
    public function show(Oras $ora): Response
    {
        return $this->render('oras/show.html.twig', [
            'ora' => $ora,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_oras_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Oras $ora, OrasRepository $orasRepository): Response
    {
        $form = $this->createForm(OrasType::class, $ora);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $orasRepository->save($ora, true);

            return $this->redirectToRoute('app_oras_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('oras/edit.html.twig', [
            'ora' => $ora,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_oras_delete', methods: ['POST'])]
    public function delete(Request $request, Oras $ora, OrasRepository $orasRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ora->getId(), $request->request->get('_token'))) {
            $orasRepository->remove($ora, true);
        }

        return $this->redirectToRoute('app_oras_index', [], Response::HTTP_SEE_OTHER);
    }
}
