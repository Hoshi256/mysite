<?php

namespace App\Controller;
use DateTime;
use Dompdf\Dompdf;
use App\Entity\User;
use App\Entity\Booking;
use App\Repository\BookingRepository;
use Symfony\Component\HttpFoundation\Request;
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

  #[Route('/generate-pdf', name: 'app_generate_invoice')]
    public function generateInvoice(Request $request, BookingRepository $bookingRepository): Response
    {
        $bookingId = $request->query->get('booking');
        $booking = $bookingRepository->find($bookingId);

        if (!$booking) {
            throw $this->createNotFoundException('Booking not found');
        }

        $user = $this->getUser();

        

        // Create a new instance of Dompdf
        $dompdf = new Dompdf();

        
        // Get the total price of the booking
$totalPrice = $booking->getPrice();


// Calculate the TVA (VAT) amount at a rate of 20%
$tva = $totalPrice * 0.2;




// Calculate the total price including TVA (VAT)
$priceWithoutTva = $totalPrice - $tva;

        // Render the HTML template as a string
        $html = $this->renderView('back_office_user/invoice.html.twig', [
            'user' => $user,
            'booking' => $booking,
            'totalPrice' => $totalPrice,
            'tva' => $tva,
            'priceWithoutTva' => $priceWithoutTva,
            'date' => new DateTime(),




        ]);

        // Load the HTML string into Dompdf
        $dompdf->loadHtml($html);

        // Set paper size and orientation
        $dompdf->setPaper('A4', 'portrait');

        // Render the PDF
        $dompdf->render();

        // Output the PDF as a response
        $response = new Response($dompdf->output());
        $response->headers->set('Content-Type', 'application/pdf');
        $response->headers->set('Content-Disposition', 'attachment;filename="invoice.pdf"');

        return $response;
    }


    //test 
    

}
