<?php
namespace App\Entity;

require_once './src/bootstrap.php';  
$user = new User(
    "test",
    "test",
    "123",  
    "test@gmail.com",
    false
);

$entityManager->persist($user);  
$entityManager->flush();           

echo "Usuario creado con ID: " . $user->getId() . "\n";
