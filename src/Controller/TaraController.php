<?php

namespace App\Controller;

use App\Entity\Tara;
use App\Form\TaraType;
use App\Repository\TaraRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/tara')]
class TaraController extends AbstractController
{
    #[Route('/', name: 'app_tara_index', methods: ['GET'])]
    public function index(TaraRepository $taraRepository): Response
    {
        return $this->render('tara/index.html.twig', [
            'taras' => $taraRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_tara_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TaraRepository $taraRepository): Response
    {
        $tara = new Tara();
        $form = $this->createForm(TaraType::class, $tara);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $taraRepository->save($tara, true);

            return $this->redirectToRoute('app_tara_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('tara/new.html.twig', [
            'tara' => $tara,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_tara_show', methods: ['GET'])]
    public function show(Tara $tara): Response
    {
        return $this->render('tara/show.html.twig', [
            'tara' => $tara,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_tara_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Tara $tara, TaraRepository $taraRepository): Response
    {
        $form = $this->createForm(TaraType::class, $tara);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $taraRepository->save($tara, true);

            return $this->redirectToRoute('app_tara_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('tara/edit.html.twig', [
            'tara' => $tara,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_tara_delete', methods: ['POST'])]
    public function delete(Request $request, Tara $tara, TaraRepository $taraRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tara->getId(), $request->request->get('_token'))) {
            $taraRepository->remove($tara, true);
        }

        return $this->redirectToRoute('app_tara_index', [], Response::HTTP_SEE_OTHER);
    }
}
