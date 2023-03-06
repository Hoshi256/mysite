<?php

namespace App\Controller;

use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GoogleController extends AbstractController
{
    #[Route('/mail', name: 'app_mail')]
    public function index(Request $request): Response
    {
            $mail = new PHPMailer(true);

        try{
    // Confoguration

    // $mail ->SMTPDebug = SMTP::DEBUG_SERVER;

    $mail->isSMTP();
    $mail->Host = "smtp.gmail.com";
    $mail->Port = 587;
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'ing.topaz@gmail.com';                     //SMTP username
    $mail->Password   = 'uuuiehtmaqnmzjpu';                               //SMTP password
    // $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption

    //xgarset

  


    //destinateire

    $mail->addAddress("daniela.puscoiu@gmail.com");
    $mail->addCC("copie@yahoo.com");

  //extediteur

    // $mail->setFrom("no-reply@site.fr");

    $subject = $request->request->get('subject');
    $body = $request->request->get('body');
    

    
            
    $mail->Subject = $subject;
    $mail->Body = $body;


    //contenu

    // $mail->Subject = "message send from symfony";
    // $mail->Body = "bjfhf fkuzfhkuf fhkufhfg";

  //  On envoie 

    $mail->send();
    echo 'message has been sent';

}catch(Exception){
    echo "Message non envoyé. Error: {$mail -> ErrorInfo}";
}



        return $this->render('google/index.html.twig', [
            'controller_name' => 'GoogleController',
        ]);
    }
}
