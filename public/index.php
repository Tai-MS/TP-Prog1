<?php
namespace App\Entity;

use Doctrine\ORM\EntityManagerInterface;
require_once '../vendor/autoload.php';
require_once '../src/Service/signUpService.php';
require_once '../src/Service/loginService.php';
require_once '../src/Service/recoverPassword.php';

$email = $_POST["email"];

$formType = $_POST['form_type'];

if($formType === 'signup'){
    $password = $_POST["password"];
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

    echo $result;
}else if($formType === 'recover'){
    $recover = new RecoverPassword("", "", "", $email, false, $entityManager);
    $result = $recover->sendEmail($email);
    header('Content-Type: application/json; charset=utf-8');

    echo $result;

}