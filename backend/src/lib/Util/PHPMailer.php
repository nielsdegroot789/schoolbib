<?php

namespace skoolBiep\Util;

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class Mailer
{
    private $mail;

    public function __construct()
    {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP(); // Send using SMTP
            $mail->Host = 'rubico.be'; // Set the SMTP server to send through
            $mail->SMTPAuth = true; // Enable SMTP authentication
            $mail->Username = 'syntracursisten@fullstacksyntra.be'; // SMTP username
            $mail->Password = 'syntra.1920'; // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port = 587; // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

        } catch (Exception $e) {
            return "Problem setting up Mailer";
        }
    }

    public function sendMail()
    {

        try {

            //Recipients
            $mail->setFrom('syntracursisten@fullstacksyntra.be');
            $mail->addAddress('emieldkr@gmail.com'); // Name is optional

            // Content
            $mail->isHTML(true); // Set email format to HTML
            $mail->Subject = 'Here is the subject';
            $mail->Body = $this->get('twig')->render('email.html.twig', [
                'naam' => 'testnaam',
            ]);
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            return "Message has been sent";
        } catch (Exception $e) {
            return "Problem sending mail";
        }
    }

}
