<?php

namespace App\Controller;
use App\Entity\User;
use App\Entity\Booking;
use App\Repository\BookingRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BackOfficeUserController extends AbstractController
{
    #[Route('/back/office/user', name: 'app_back_office_user')]
    public function idex(BookingRepository $bookingRepository): Response
    {
        $user=$this->getUser();

    
        $history= $bookingRepository -> findBy([
            'user' => $user,
            
        ]);  

        
       

        return $this->render('back_office_user/index.html.twig', [
            'user' => $user,
            'history'=> $history,

        ]);

    }
}
