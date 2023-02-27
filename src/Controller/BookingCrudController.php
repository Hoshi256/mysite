<?php

namespace App\Controller;
use App\Entity\User;
use App\Entity\Booking;
use App\Form\BookingType;
use App\Repository\BookingRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

#[Route('/booking/crud')]
class BookingCrudController extends AbstractController
{
    #[Route('/', name: 'app_booking_crud_index', methods: ['GET'])]
    public function index(BookingRepository $bookingRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        return $this->render('booking_crud/index.html.twig', [
            'bookings' => $bookingRepository->findAll(),
        ]);
    }


    #[Route('/new', name: 'app_booking_crud_new', methods: ['GET', 'POST'])]
    public function new(Request $request, BookingRepository $bookingRepository): Response
    {   
        

          $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $booking = new Booking();
        $form = $this->createForm(BookingType::class, $booking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bookingRepository->save($booking, true);

            return $this->redirectToRoute('app_booking_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('booking_crud/new.html.twig', [
            'booking' => $booking,
            'form' => $form,
        ]);

    }
   
    






    #[Route('/user_add_booking', name: 'app_user_add_booking_crud_new', methods: ['GET', 'POST'])]
    public function user_add_booking(Request $request, BookingRepository $bookingRepository): Response
    {
        $booking = new Booking();
        $form = $this->createForm(BookingType::class, $booking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bookingRepository->save($booking, true);

            return $this->redirectToRoute('app_booking_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('booking_crud/new.html.twig', [
            'booking' => $booking,
            'form' => $form,
        ]);
    }


    #[Route('/{id}', name: 'app_booking_crud_show', methods: ['GET'])]
    public function show(Booking $booking): Response
    {
        return $this->render('booking_crud/show.html.twig', [
            'booking' => $booking,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_booking_crud_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Booking $booking, BookingRepository $bookingRepository): Response
    {    
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $form = $this->createForm(BookingType::class, $booking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bookingRepository->save($booking, true);

            return $this->redirectToRoute('app_booking_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('booking_crud/edit.html.twig', [
            'booking' => $booking,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_booking_crud_delete', methods: ['POST'])]
    public function delete(Request $request, Booking $booking, BookingRepository $bookingRepository): Response
    {    
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        if ($this->isCsrfTokenValid('delete'.$booking->getId(), $request->request->get('_token'))) {
            $bookingRepository->remove($booking, true);
        }

        return $this->redirectToRoute('app_booking_crud_index', [], Response::HTTP_SEE_OTHER);
    }


}
