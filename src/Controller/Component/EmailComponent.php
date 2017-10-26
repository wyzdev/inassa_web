<?php

namespace App\Controller\Component;
use Cake\Controller\Component;

require_once(ROOT . DS . 'vendor' . DS  . 'phpmailer' . DS . 'class.phpmailer.php');

class EmailComponent extends Component {

    public function send($to, $subject, $message, $attachment = null) {
        $sender = "info@nassagroup.com"; // this will be overwritten by GMail

        $header = "X-Mailer: PHP/".phpversion() . "Return-Path: $sender";

        $mail = new \PHPMailer(true);

        $mail->IsSMTP();
        // $mail->SMTPDebug = 2;
        $mail->Debugoutput = 'html';
        $mail->Host = "box1074.bluehost.com";
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "ssl";
        $mail->Port = 465;
        $mail->Username   = "info@nassagroup.com";
        $mail->Password   = "info1234!";

        $mail->From = $sender;
        $mail->FromName = "INASSA";

        if ($attachment != null) {
            $mail->addAttachment($attachment);
        }

        $mail->AddAddress($to);

        $mail->IsHTML(true);
        $mail->CreateHeader($header);

        $mail->Subject = $subject;
        $mail->MsgHTML($message);

      /*  $mail->Body    = nl2br($message);
        $mail->AltBody = nl2br($message);*/


        //set_time_limit(3600);
        // $mail->Timeout = 3600;

        // return an array with two keys: error & message
        if(!$mail->Send()) {
            return array('error' => true, 'message' => 'Mailer Error: ' . $mail->ErrorInfo);
        } else {
            return array('error' => false, 'message' =>  "Message sent!");
        }
    }
}

