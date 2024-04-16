<?php
require_once __DIR__ . "../PHPMailer/src/PHPMailer.php";
require_once __DIR__ . "../PHPMailer/src/SMTP.php";
require_once __DIR__ . "../PHPMailer/src/Exception.php";


class SendMail
{
    private $db; // PDO instance
    private $mailer; // PHPMailer instance

    public function __construct($db)
    {
        $this->db = $db;

        // Configure PHPMailer
        $this->mailer = new PHPMailer\PHPMailer\PHPMailer();
        $this->mailer->isSMTP();
        $this->mailer->Host = 'smtp.gmail.com'; // Your SMTP host
        $this->mailer->SMTPAuth = true;
        $this->mailer->Username = 'testmailforwork01@gmail.com'; // Your SMTP username
        $this->mailer->Password = 'lbvs ieis oqvn zhtb'; // Your SMTP password
        $this->mailer->SMTPSecure = 'ssl';
        $this->mailer->Port = 465;
        $this->mailer->setFrom('testmailforwork01@gmail.com', 'Auto Test'); // Your email address and name
        $this->mailer->isHTML(true);
        $this->mailer->CharSet = 'UTF-8';
    }

    public function send($recipient, $subject, $body)
    {
        $this->mailer->addAddress($recipient); // Recipient email address
        $this->mailer->Subject = $subject;
        $this->mailer->Body = $body;

        if ($this->mailer->send()) {
            return true;
        } else {
            // Email sending failed
            return false;
        }
    }

    public function SendMail(array $recipients, $subject, $body)
    {
        foreach($recipients as $recipient){
            $this->mailer->addAddress($recipient); // Recipient email address
        }
        $this->mailer->Subject = $subject;
        $this->mailer->Body = $body;

        if ($this->mailer->send()) {
            return true;
        } else {
            // Email sending failed
            return false;
        }
    }

}
