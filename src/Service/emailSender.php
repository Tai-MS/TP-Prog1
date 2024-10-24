<?php
namespace App\Entity;

use Dotenv\Dotenv;
use Doctrine\ORM\EntityManagerInterface;
use Throwable;
require_once __DIR__ . '/../bootstrap.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$dotenv = Dotenv::createImmutable(__DIR__. "/../..");  
$dotenv->load();

class EmailSender extends UserData {
    private EntityManagerInterface $entityManager;

    public function __construct(string $name, string $lastname, string $password, string $email, bool $adminPrivileges,EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
        parent::__construct($name, $lastname, $password, $email, $adminPrivileges, $entityManager); 
    }

    public function verifyEmail($email, $subject, $body){
        try {
            $email_exists = $this->emailExists($email);
            //Means: User doesnt found
            if(!$email_exists){
                return 0;
            }
            $this->sendEmail($email, $subject, $body);
        } catch (Throwable $err) {
            return $err;
        }
    }

    public function sendTicket($email, $subject, $body){
        $EMAIL_SENDER = $_ENV['EMAIL_SENDER'];
        $EMAIL_SENDER_PASSWORD = $_ENV['EMAIL_SENDER_PASSWORD'];
        $mail = new PHPMailer(true);
        $EMAIL_SENDER = $_ENV['EMAIL_SENDER'];
        $EMAIL_SENDER_PASSWORD = $_ENV['EMAIL_SENDER_PASSWORD'];
        $mail = new PHPMailer(true);

        $mail->isSMTP(); 
        $mail->Host = 'smtp.gmail.com'; 
        $mail->SMTPAuth = true; 
        $mail->Username = $EMAIL_SENDER; 
         $mail->Password = $EMAIL_SENDER_PASSWORD; 
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
        $mail->Port = 587; 

        $mail->setFrom($EMAIL_SENDER, 'Your last ticket.');
        $mail->addAddress($email);

        $mail->isHTML(true); 
        $mail->Subject = $subject; 
        $mail->Body    = $body; 

        $mail->send();

        return json_encode('Mail sent successfully!');
    }
    public function sendEmail($email, $subject, $body, $cookie = ''){
        $EMAIL_SENDER = $_ENV['EMAIL_SENDER'];
        $EMAIL_SENDER_PASSWORD = $_ENV['EMAIL_SENDER_PASSWORD'];
        $mail = new PHPMailer(true);

        $mail->isSMTP(); 
        $mail->Host = 'smtp.gmail.com'; 
        $mail->SMTPAuth = true; 
        $mail->Username = $EMAIL_SENDER; 
         $mail->Password = $EMAIL_SENDER_PASSWORD; 
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
        $mail->Port = 587; 

        $mail->setFrom($EMAIL_SENDER, 'Change password');
        $mail->addAddress($email);

        $mail->isHTML(true); 
        $mail->Subject = $subject; 
        $mail->Body    = $body; 

        $mail->send();

        return json_encode('Mail sent successfully!');
    }

    public function changePassword($email, $newPassword){
        try {
        } catch (Throwable $err) {
            return $err;
        }
    }
}