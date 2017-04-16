<?php

namespace App\Controller\Component;
use Cake\Controller\Component;

require_once(ROOT . DS . 'vendor' . DS  . 'phpmailer' . DS . 'class.phpmailer.php');

class EmailComponent extends Component {

    public function send($to, $subject, $message) {
        $sender = "hollynderisse93@gmail.com"; // this will be overwritten by GMail

        $header = "X-Mailer: PHP/".phpversion() . "Return-Path: $sender";

        $mail = new \PHPMailer();

        $mail->IsSMTP();
        $mail->SMTPDebug = 2;
        $mail->Debugoutput = 'html';
        $mail->Host = "smtp.gmail.com";
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "ssl";
        $mail->Port = 465;
        $mail->SMTPDebug  = 2; // turn it off in production
        $mail->Username   = "hollynderisse93@gmail.com";
        $mail->Password   = "HDR2013#";

        $mail->From = $sender;
        $mail->FromName = "INASSA";

        $mail->AddAddress($to);

        $mail->IsHTML(true);
        $mail->CreateHeader($header);

        $mail->Subject = $subject;
        $mail->Body    = nl2br($message);
        $mail->AltBody = nl2br($message);

        // return an array with two keys: error & message
        if(!$mail->Send()) {
            return array('error' => true, 'message' => 'Mailer Error: ' . $mail->ErrorInfo);
        } else {
            return array('error' => false, 'message' =>  "Message sent!");
        }
    }
}

