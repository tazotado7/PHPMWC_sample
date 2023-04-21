<?php
require_once ROOT . '/app/helpers/PHPMailer/PHPMailer/PHPMailer.php';

require_once ROOT . '/app/helpers/PHPMailer/PHPMailer/SMTP.php';

require_once ROOT . '/app/helpers/PHPMailer/PHPMailer/Exception.php';
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class PHPmail
{
    private $host = 'mail.iaia.ge';
    private $Username = 'info@iaia.ge';
    private $Password = 'Aladashvil1email';


    private $setFrom_email = 'info@iaia.ge';
    private $setFrom_name = 'INFO';
    private $AltBody = 'Thank you';
    public function __construct()
    {

    }
    public function send_info_mail($email, $Subject, $Body)
    {
        $mail = new PHPMailer(true);
        try {
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host = $this->host;
            $mail->SMTPAuth = true;
            $mail->Username = $this->Username;
            $mail->Password = $this->Password;
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;
            $mail->CharSet = 'UTF-8';
            $mail->Encoding = 'base64';
            $mail->setFrom($this->setFrom_email, $this->setFrom_name);
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = $Subject;
            $mail->Body = $Body;
            $mail->AltBody = $this->AltBody;
            $mail->send();

            $data['resoult'] = 'ok';
            $data['msg'] = 'Confirmtaion Message has been sent to your email';
        } catch (Exception $e) {
            $data['resoult'] = 'no';
            $data['msg'] = 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
        }
        return $data;
    }
}