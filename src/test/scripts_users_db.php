<?php

// namespace App\Entity;
// require_once __DIR__ . '/../bootstrap.php';
// require_once __DIR__ . '/../Service/signUpService.php';

// $singUpService = new SignUp();

// $jsonData = file_get_contents(__DIR__ . '/../users.json');
// $usersArray = json_decode($jsonData, true); 

// if ($usersArray === null) {
//     die('Error al leer el archivo JSON.');
// }

// foreach ($usersArray as $userData) {
//     // Extraer los datos de cada producto
//     $name = $userData['name'];
//     $lastname = $userData['lastname'];
//     $password = $userData['password'];
//     $email = $userData['email'];
//     $adminPrivileges = $userData['adminPrivileges'];
//     $singUpService->create_user($email, $name, $lastname, $password, $adminPrivileges);
//     echo "Producto creado: $name" . PHP_EOL;
// }
