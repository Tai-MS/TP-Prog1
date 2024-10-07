<?php
namespace App\Entity;

use Doctrine\ORM\EntityManagerInterface;
require_once '../vendor/autoload.php';
require_once '../src/Service/signUpService.php';
require_once '../src/Service/loginService.php';

$password = $_POST["password"];
$email = $_POST["email"];

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

    echo $result;
}