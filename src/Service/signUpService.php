<?php
namespace App\Entity;

use Dotenv\Dotenv;
use Doctrine\ORM\EntityManagerInterface;
use Throwable;

require_once __DIR__ . '/../bootstrap.php';

$dotenv = Dotenv::createImmutable(__DIR__. "/../..");  
$dotenv->load();


class SignUp extends UserData {
    private EntityManagerInterface $entityManager;

    public function __construct(string $name, string $lastname, string $password, string $email, bool $adminPrivileges,EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
        parent::__construct($name, $lastname, $password, $email, $adminPrivileges, $entityManager); 
    }

    public function check_email(string $email): UserData | bool | Throwable {

        $email_in_use =  $this->emailExists($email);
        if($email_in_use === null){
            return false;
        }

        return $email_in_use;
    }

    public function hash_password(string $password): string | Throwable {
        try {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            return $hashed_password;
        } catch (Throwable $err) {
            return $err;
        }
    }

    public function create_user(string $email, string $name, string $lastname, string $password, bool $adminPrivileges): string | Throwable | array {
        $response = [
            'status' => '',
            'message' => ''
        ];
        $email_in_use = $this->check_email($email); 
        if ($email_in_use) {
            $response['status'] = 'error';
            $response['message'] = 'Email already in use'; 
            
            return $response;
        }
        
        $hashed_password = $this->hash_password($password);

        try {
            $new_user = new UserData(
                $name,
                $lastname,
                $hashed_password,
                $email,
                $adminPrivileges,
                $this->entityManager 
            );
            $this->entityManager->persist($new_user);  
            $this->entityManager->flush();
    
            $response['status'] = 'success';
            $response['message'] = 'User created';
            $response['redirect'] = '/src/views/login.html';

            return $response;
        } catch (Throwable $err) {
            return $err;
        }
    }
}

