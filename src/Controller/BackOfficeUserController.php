<?php

namespace App\Controller;
use DateTime;
use Dompdf\Dompdf;
use App\Entity\User;
use App\Entity\Booking;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

use App\Repository\BookingRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
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
    public function generateInvoice(Request $request, BookingRepository $bookingRepository, MailerInterface $mailer): Response
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
$unitPrice = $booking->getPrice();

$nbperson = $booking ->getNbPerson();

$total = $unitPrice * $nbperson;
// Calculate the TVA (VAT) amount at a rate of 20%
$tva = $unitPrice * 0.2;


 

// Calculate the total price including TVA (VAT)
$priceWithoutTva = $unitPrice - $tva;

        // Render the HTML template as a string
        $html = $this->renderView('back_office_user/invoice.html.twig', [
            'user' => $user,
            'booking' => $booking,
            'nbperson' => $nbperson,
            'total' => $total,
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

        $pdfContents = $dompdf->output();

        // Output the PDF as a response
   


        // $email = $user->getEmail();
        // dd($email);
    

        $mail = new PHPMailer(true);


            try {
                $mail->isSMTP();
                $mail->Host = "smtp.gmail.com";
                $mail->Port = 587;
                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                $mail->Username   = 'daniela.puscoiu@gmail.com';                     //SMTP username
                $mail->Password   = 'yupppwccfpbaigsn';   
                $mail->Body = 'Hello, this is the content of the email message.';
                $mail->msgHTML('<p>Hello, this is the content of the email message.</p>');
                $mail->setFrom("no-reply@site.fr");
                $mail->addAddress($user->getEmail());
                $mail->Subject = 'Invoice for booking #' . $booking->getId();

                $mail->addStringAttachment($pdfContents, 'invoice.pdf', PHPMailer::ENCODING_BASE64, 'application/pdf');

                $mail->send();

        $response = new Response($dompdf->output());
        $response->headers->set('Content-Type', 'application/pdf');
        $response->headers->set('Content-Disposition', 'attachment;filename="invoice.pdf"');

                        } catch(Exception $e) {
        return new Response('Error sending email: ' . $mail->ErrorInfo);
                        }



        return $response;



    }


    //test 
    

}
