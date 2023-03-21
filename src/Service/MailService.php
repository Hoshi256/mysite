<?php

namespace App\Service;



class MailService
{
    private $mail;
     public function __construct(\PHPMailer\PHPMailer\PHPMailer $phpmailer)
     {
        $this->mail = $phpmailer;
        $this->mail->isSMTP();
        $this->mail->Host = "smtp.gmail.com";
        $this->mail->Port = 587;
        $this->mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        // $mail->Username   = 'daniela.puscoiu@gmail.com';                     //SMTP username
        // $mail->Password   = 'yupppwccfpbaigsn'; 
        $this->mail->Username   = 'ing.topaz@gmail.com';                     //SMTP username
        $this->mail->Password   = 'kztkaawsrdtveuyb';    
        $this->mail->setLanguage('fr', '/optional/path/to/language/directory/');
     }

    public function setRecipent ($email, $subject, $body) 
    {
        $this->mail->addAddress($email);
        $this->mail->Subject = $subject;
        $this->mail->Body = $body;

        $this->mail->isHTML();
    }
    // $mail ->SMTPDebug = SMTP::DEBUG_SERVER;
    public function sendMail ()
    {
        $this->mail->send();
    }
    
}

