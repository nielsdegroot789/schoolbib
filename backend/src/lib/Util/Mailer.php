<?php

namespace skoolBiep\Util;

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class Mailer
{
    private $mail;

    public function __construct()
    {
        $this->mail = new PHPMailer(true);
        try {
            $this->mail->isSMTP(); // Send using SMTP
            $this->mail->Host = 'rub-i-con.be'; // Set the SMTP server to send through
            $this->mail->SMTPAuth = true; // Enable SMTP authentication
            $this->mail->Username = 'syntracursisten@fullstacksyntra.be'; // SMTP username
            $this->mail->Password = 'syntra.1920'; // SMTP password
            $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $this->mail->Port = 587; // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

        } catch (Exception $e) {
            return "Problem setting up Mailer";
        }
    }

    public function sendMail(String $address, String $body, String $subject): String
    {

        try {
            //Recipients
            $this->mail->setFrom('skoolbib@skoolbib.be');
            //todo change with $address
            $this->mail->addAddress('emieldkr@gmail.com');

            // Content
            $this->mail->isHTML(true);
            $this->mail->Subject = $subject;
            $this->mail->Body = $body;
            // $this->mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $this->mail->send();
            return "Message has been sent";
        } catch (Exception $e) {
            throw new Exception('Error sending email:' . $e->getMessage());
        }
    }

}
