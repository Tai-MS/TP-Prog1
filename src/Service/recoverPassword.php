<?php
namespace App\Entity;

use Dotenv\Dotenv;
use Doctrine\ORM\EntityManagerInterface;
use Throwable;
require_once __DIR__ . '/../bootstrap.php';

$dotenv = Dotenv::createImmutable(__DIR__. "/../..");  
$dotenv->load();

class RecoverPassword extends UserData {
    private EntityManagerInterface $entityManager;

    public function __construct(string $name, string $lastname, string $password, string $email, bool $adminPrivileges,EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
        parent::__construct($name, $lastname, $password, $email, $adminPrivileges, $entityManager); 
    }

    public function changePassword($email, $newPassword){
        try {
            $response = [
                'status' => '',
                'message' => ''
            ];
            $user = $this->emailExists($email);
    
            if ($user === null) {
                throw new \Exception('El usuario no existe.');
            }
            
            $hashed_password = password_hash($newPassword, PASSWORD_DEFAULT);

            $user->setPassword($hashed_password);

            $this->entityManager->persist($user);
            $this->entityManager->flush();
            
            $response['status'] = 'success';
            $response['message'] = 'Password updated';
            $response['redirect'] = '/src/views/login.html';
            
            return json_encode($response);
        } catch (Throwable $err) {
            return $err;
        }
    }
    
}