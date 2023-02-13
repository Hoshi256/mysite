<?php

namespace App\Controller;

use App\Entity\Pays;
use App\Form\Pays1Type;
use App\Repository\PaysRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/pays/controller2')]
class PaysController2Controller extends AbstractController
{
    #[Route('/', name: 'app_pays_controller2_index', methods: ['GET'])]
    public function index(PaysRepository $paysRepository): Response
    {
        return $this->render('pays_controller2/index.html.twig', [
            'pays' => $paysRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_pays_controller2_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PaysRepository $paysRepository): Response
    {
        $pay = new Pays();
        $form = $this->createForm(Pays1Type::class, $pay);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $paysRepository->save($pay, true);

            return $this->redirectToRoute('app_pays_controller2_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('pays_controller2/new.html.twig', [
            'pay' => $pay,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_pays_controller2_show', methods: ['GET'])]
    public function show(Pays $pay): Response
    {
        return $this->render('pays_controller2/show.html.twig', [
            'pay' => $pay,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_pays_controller2_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Pays $pay, PaysRepository $paysRepository): Response
    {
        $form = $this->createForm(Pays1Type::class, $pay);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $paysRepository->save($pay, true);

            return $this->redirectToRoute('app_pays_controller2_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('pays_controller2/edit.html.twig', [
            'pay' => $pay,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_pays_controller2_delete', methods: ['POST'])]
    public function delete(Request $request, Pays $pay, PaysRepository $paysRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$pay->getId(), $request->request->get('_token'))) {
            $paysRepository->remove($pay, true);
        }

        return $this->redirectToRoute('app_pays_controller2_index', [], Response::HTTP_SEE_OTHER);
    }
}
