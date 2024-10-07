<?php
namespace App\Entity;

use Dotenv\Dotenv;
use Doctrine\ORM\EntityManagerInterface;
use Throwable;

require_once __DIR__ . '/../bootstrap.php';

$dotenv = Dotenv::createImmutable(__DIR__. "/../..");  
$dotenv->load();
$SECRET_KEY = $_ENV['SECRET_KEY'];

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
    public function toArray(): array {
        return [
            'name' => $this->name,
            'lastname' => $this->lastname,
            'email' => $this->email,
            'adminPrivileges' => $this->adminPrivileges
        ];
    }
    public function hash_password(string $password): string | Throwable {

        try {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            return $hashed_password;
        } catch (Throwable $err) {
            return $err;
        }
    }

    public function create_user(string $email, string $name, string $lastname, string $password, bool $adminPrivileges): string | Throwable {
        $email_in_use = $this->check_email($email); 
        //  var_dump($email_in_use !== null);
        if ($email_in_use) {
            return "Email already in use";
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
    
            return "User created. ID: " . $new_user->getId();
        } catch (Throwable $err) {
            return $err;
        }
    }
}

// $name = "John";
// $lastname = "Doe";
// $email = "johnd.doe@exampledda.com";
// $password = "securepassword"; 
// $adminPrivileges = false;

// $signUp = new SignUp($name, $lastname, $password, $email, $adminPrivileges, $entityManager);

// $result = $signUp->create_user($email, $name, $lastname, $password, $adminPrivileges);
// echo $result;

