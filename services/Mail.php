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
     $mail->Port       = 465;                                   //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
     $mail->setLanguage('fr');
 }

 public function sendMail($receiver){ //FONCTION PRINCIPALE, APPELEE PAR LES AUTRES
     $this -> mail -> setFrom($_ENV["MAIL_USER"]); //EMAIL D'ENVOI
     $this -> mail -> addAddress($receiver); //EMAIL DU DESTINATAIRE

     //Content
     $this -> mail->isHTML(true);   //FORMATE L'EMAIL EN HTML
 }

 public function sendMailFromForm($receiver, $subject, $body){ //FONCTION SPECIFIQUE POUR LES QUESTIONNAIRES
     try {
         $this->sendMail($receiver); //APPEL DE LA FONCTION PRINCIPALE

         $this->mail->Subject = $subject; //OBJET DU MAIL (passé en argument)
         $this->mail->Body = $body; //CORPS DU MAIL (passé en argument)

         $this -> mail->send(); //ENVOI LE MAIL
         echo 'Message envoyé';
     }
     catch (Exception $e) { //SI IL Y A UNE ERREUR
        echo "Message non envoyé: {$this -> mail->ErrorInfo}"; //MESSAGE AFFICHE DES PRECISIONS
    }
 }

}