<?php
namespace App\Entity;

use Doctrine\ORM\EntityManagerInterface;
require_once '../vendor/autoload.php';
require_once '../src/Service/signUpService.php';
require_once '../src/Service/loginService.php';
require_once '../src/Service/recoverPassword.php';
require_once '../src/Service/emailSender.php';


if(isset($_POST["email"])){
    $email = $_POST["email"];
}

if(isset($_POST["password"])){
    $password = $_POST["password"];  
}
require_once '../src/Service/recoverPassword.php';
require_once '../src/Service/emailSender.php';


if(isset($_POST["email"])){
    $email = $_POST["email"];
}

if(isset($_POST["password"])){
    $password = $_POST["password"];  
}

$formType = $_POST['form_type'];

if($formType === 'signup'){
    $name = $_POST["name"];
    $lastname = $_POST["lastname"];
    $adminPrivileges = false;
    $usr = new SignUp($name, $lastname, $password, $email, $adminPrivileges, $entityManager);
    header('Content-Type: application/json; charset=utf-8');


    $result = $usr->create_user($email, $name, $lastname, $password, $adminPrivileges);


    echo json_encode($result);

}else if($formType === 'login'){
    $login = new LoginService("", "", $password, $email, false, $entityManager);
    header('Content-Type: application/json; charset=utf-8');

    $result = $login->login($email, $password);
    
    // var_dump($result['specialCookie']);
    echo $result;
}else if($formType === 'recover'){

    $recover = new EmailSender("", "", "", $email, false, $entityManager);
    $cookie = setcookie('email', $email, time() + 3600, '/');
    $subject = 'Password Recovery';
    $body = 'Click the link to recover your password: <a href="http://localhost:3030/src/views/recoverPassword.html">Recover Password</a>';
    $result = $recover->sendEmail($email, $subject, $body, $cookie);
    header('Content-Type: application/json; charset=utf-8');

    echo $result;

}else if($formType === 'change'){
    $cookie_email = $_COOKIE['email'];

    $change_pass = new RecoverPassword("", "", $password, $cookie_email, false, $entityManager);

    header('Content-Type: application/json; charset=utf-8');
    $result = $change_pass->changePassword($cookie_email, $password);
    error_log($result);
    echo $result;
}