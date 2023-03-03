<?php

namespace App\Controller;

use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Address;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Notifier\Exception\TransportExceptionInterface;

class MailerController extends AbstractController
{
    #[Route('/mailer', name: 'app_mailer')]
    public function sendEmail(MailerInterface $mailer): Response
    {
         $email = (new Email())
            ->from('ing.topaz@gmail.com')
            
            // ->from(new Address('ing.topaz@gmail.com'))

            ->to('daniela.puscoiu@gmail.com')
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Time for Symfony Mailer!')
            ->text('Sending emails is fun again!')
            ->html('<p>See Twig integration for better HTML integration!</p>');



                                                // dd($email);


        try {
            $mailer->send($email);

            $message = 'Your email was sent successfully!';
                    // dd($email);

        } catch (TransportExceptionInterface $e) {
            $message = 'There was an error sending your email: ' . $e->getMessage();
                dd($message);

        }

            
    // some error prevented the email sending; display an
    // error message or try to resend the message


        // ..



        return $this->render('mailer/index.html.twig', [
            'message' => $message,
        ]);
    }

// public function sendEmail(MailerInterface $mailer): Response
//     {
//         $message = '';

//         if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//             $email = (new Email())
//                 ->from('ing.topz@gmail.com')
//                 ->to('daniela.puscoiu@gmail.com')
//                 ->subject('Test Email')
//                 ->text('This is a test email sent using Symfony Mailer.');

//             try {
//                 $mailer->send($email);
//                 $message = 'Your email was sent successfully!';
//             } catch (TransportExceptionInterface $e) {
//                 $message = 'An error occurred while sending the email: ' . $e->getMessage();
//             }
//         }
//                 dd($message);
//         return $this->render('mailer/index.html.twig', [
//             'message' => $message,
//         ]);
//     }

}
