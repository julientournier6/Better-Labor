<!DOCTYPE html>

<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

function sendmail($conn, $row, $subject, $body, $file = NULL, $admin = 0){
    $mail = new PHPMailer(true);
    $mail->Mailer = "smtp";
    $mail->SMTPSecure = 'tls';
    $mail->SMTPDebug = 0;
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'contact.betterlabor@gmail.com';
    $mail->Password = 'agcfeudoeyqufidf';
    $mail->Port = 587;
    $mail->CharSet = 'UTF-8';
    $mail->setFrom('contact.betterlabor@gmail.com', 'Better Labor');
    if (!is_null($file)) {
        $mail->addAttachment($file);
    }
    $mail->isHTML(true);
    $mail->Subject = $subject;
    try {
        $mail->addAddress($row->email);
        if ($admin) {
            $mail->Body = 'Demande reçue de la part de ' . $row->email . ' depuis notre site web : ' . '<br>
            Prenom : ' . $row->prenom . '<br>
            Nom : '. $row->nom . '<br><br>
            ' . $body . '
            <br>Infinite Measures<br>Service Better Labor<br><a href="127.0.0.1/Better-Labor">Le site</a>';
            $mail->AltBody = 'Mail envoyé de la part de $row->email depuis notre site web :  
            <br>
            Prenom :  $row->prenom
            Nom : $row->nom
            $body
            <br>
            <br>
            Infinite Measures
            Service Better Labor
            Le site : 127.0.0.1/Better-Labor';
        }
        else {
            
            $mail->Body = 'Bonjour ' . $row->prenom . ' ' . $row->nom . '!<br><br>' . $body . '<br><br>Infinite Measures<br>Service Better Labor<br><a href="127.0.0.1/Better-Labor">Notre site</a>';
            $mail->AltBody = 'Bonjour ' . $row->prenom . ' ' . $row->nom . '! ' . $body . 'Infinite Measures
            Service Better Labor
            Infinite Measures
            https://127.0.0.1/Better-Labor';
        }
        $mail->send();
        return true;
    }
    catch (Exception $e) {
        echo $e->getMessage();
        return false;
    }
}
?>