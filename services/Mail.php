<?php

use PHPMailer\PHPMailer\PHPMailer;

class Mail
{
 public function __construct(private PHPMailer $mail = new PHPMailer(true)) {
     $mail->isSMTP();                                            //Send using SMTP
     $mail->Host       = 'smtp.example.com';                     //Set the SMTP server to send through
     $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
     $mail->Username   = 'user@example.com';                     //SMTP username
     $mail->Password   = '.env';                               //SMTP password
     $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
     $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
 }

 public function sendMail(){
     $mail->setFrom('from@example.com', 'Mail');
     $mail->addAddress('ellen@example.com');               //Name is optional

     //Content
     $mail->isHTML(true);                                  //Set email format to HTML
 }

 public function sendMailFromForm($subject, $body){
     $mail->Subject = 'Here is the subject';
     $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
 }

}