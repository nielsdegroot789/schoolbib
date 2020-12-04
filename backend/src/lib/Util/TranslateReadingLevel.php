<?php

namespace skoolBiep\Util;

class TranslateReadingLevel
{
    private $arr = [
        "NON_MATURE" => "adult",
        "MATURE" => "",
    ];

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
}
