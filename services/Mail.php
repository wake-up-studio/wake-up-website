<?php

use PHPMailer\PHPMailer\PHPMailer;

class Mail
{
 public function __construct(private PHPMailer $mail = new PHPMailer(true)) {
     $mail->isSMTP();                                            //Send using SMTP
     $mail->Host       = $_ENV['MAIL_HOST'];                     //Set the SMTP server to send through
     $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
     $mail->Username   = $_ENV['MAIL_USER'];                     //SMTP username
     $mail->Password   = $_ENV['MAIL_PASS'];                     //SMTP password
     $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
     $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
 }

 public function sendMail($receiver){
     $this -> mail -> setFrom($_ENV["MAIL_USER"]);
     $this -> mail -> addAddress($receiver);

     //Content
     $this -> mail->isHTML(true);   //Set email format to HTML
 }

 public function sendMailFromForm($receiver, $subject, $body){
     try {
         $this->sendMail($receiver);

         $this->mail->Subject = $subject;
         $this->mail->Body = $body;

         $this -> mail->send();
         echo 'Message envoyé';
     }
     catch (Exception $e) {
        echo "Message non envoyé: {$this -> mail->ErrorInfo}";
    }
 }

}