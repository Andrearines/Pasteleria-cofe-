<?php
namespace models;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class email extends main
{ 
   

    public function __construct(public $name, public $email)
    {
       
    }

    public function sendEmail($subject, $body)
    {
        $mail = new PHPMailer(true);
      
            //Server settings
            $mail->isSMTP();
            $mail->Host = 'sandbox.smtp.mailtrap.io'; 
            $mail->SMTPAuth = true;
            $mail->Username = "33c3224249760c";
            $mail->Password = "4bac635764afd4";
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587; 
            $mail->setFrom("andremartines2010@gmail.com", "Andres Martines");
            $mail->addAddress($this->email); 
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $body;
            $mail->send();
            
      
    
}}