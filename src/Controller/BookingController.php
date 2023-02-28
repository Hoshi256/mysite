<?php

namespace App\Controller;
use DateTime;
use app\Entity\User;
use DateTimeInterface;
use App\Entity\Booking;
use App\Entity\Product;
use Doctrine\ORM\EntityManager;
use App\Repository\BookingRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BookingController extends AbstractController
{
    #[Route('/booking', name: 'app_booking')]
    public function index(): Response
    {
        return $this->render('booking/booking.html.twig', [
            'controller_name' => 'BookingController',
        ]);
    }

     #[Route('/booking/save', name: 'app_save_booking')]
    public function save(SessionInterface $session, EntityManagerInterface $entityManagerInterface, BookingRepository $bookingRepository, ProductRepository $productRepository): Response
    {


        $cart = $session->get('cart');

           if (!$cart) {
        return $this->redirectToRoute('app_home');

    }   
        
            $user=$this->getUser();
                foreach($cart as $key=>$value) {
            $product = $productRepository->find($key);


            $booking = new Booking();
            $booking->setProduct($product);
            $booking->setUser($user);
            $booking->setPrice($product->getPrice());
            $booking->setDateIn($product->getDateIn());
            $booking->setDateOut($product->getDateOut());
            $booking->setNbPerson($value);

        }
        
          
        $entityManagerInterface->persist($booking);

        $entityManagerInterface->flush();


        $session->remove('cart');




        
        return $this->render('booking/index.html.twig', [
            'user' => $user,
            'booking' =>$booking,
                       

            'controller_name' => 'BookingController',
        ]);
    }
}


