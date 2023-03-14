<?php

namespace App\Controller;

use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GoogleController extends AbstractController
{
    #[Route('/mail', name: 'app_mail')]
    public function index(Request $request): Response
    {
            $mail = new PHPMailer(true);

        try{
    // $mail ->SMTPDebug = SMTP::DEBUG_SERVER;

    $mail->isSMTP();
    $mail->Host = "smtp.gmail.com";
    $mail->Port = 587;
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    // $mail->Username   = 'daniela.puscoiu@gmail.com';                     //SMTP username
    // $mail->Password   = 'yupppwccfpbaigsn'; 
    $mail->Username   = 'ing.topaz@gmail.com';                     //SMTP username
    $mail->Password   = 'kztkaawsrdtveuyb';    
    $mail->setLanguage('fr', '/optional/path/to/language/directory/');
                            //SMTP password
    
    $to = $request->request->get('to');
    // $cc = $request->request->get('cc');
    $mail->addAddress($to);

    // $mail->setFrom("no-reply@site.fr");

    $subject = $request->request->get('subject');
    $body = $request->request->get('body');
       
    $mail->Subject = $subject;
    $mail->Body = $body;

    $mail->isHTML();


            $attachment = $request->files->get('attachment');
            if ($attachment instanceof UploadedFile) {
                $mail->addAttachment($attachment->getPathname(), $attachment->getClientOriginalName());
            }

  //  On envoie 

    $mail->send();
    echo 'message has been sent';

    } catch (Exception $e) {
            $message = [
                'text' => 'An error occurred while sending the email: ' . $mail->ErrorInfo,
                'type' => 'danger',
            ];
        }



        return $this->render('google/index.html.twig', [
            'controller_name' => 'GoogleController',
        ]);
    }
}
