<?php
namespace App\Entity;

use Dotenv\Dotenv;
use Doctrine\ORM\EntityManagerInterface;
use Throwable;

require_once __DIR__ . '/../bootstrap.php';

$dotenv = Dotenv::createImmutable(__DIR__. "/../..");  
$dotenv->load();
$SECRET_KEY = $_ENV['SECRET_KEY'];

class LoginService extends UserData {

    private EntityManagerInterface $entityManager;

    public function __construct(string $name, string $lastname, string $password, string $email, bool $adminPrivileges,EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
        parent::__construct($name, $lastname, $password, $email, $adminPrivileges, $entityManager); 
    }

    public function comparePassword($email, $password){

        try {
            $email_exists = $this->emailExists($email);
            //Means: User doesnt found
            if(!$email_exists){
                return 0;
            }
            $saved_password = $email_exists->getPassword();
            $isPasswordValid = password_verify($password, $saved_password);

            

            return $isPasswordValid;
        } catch (Throwable $err) {
            return $err;
        }
    }

    public function login($email, $password): string | bool | Throwable{
        try {
            $verify_password = $this->comparePassword($email, $password);
            $response = [
                'status' => '',
                'message' => ''
            ];
            
            if($verify_password === 0){
                $response['status'] = 'error';
                $response['message'] = 'User not found';
            }else if(!$verify_password){
                $response['status'] = 'error';
                $response['message'] = 'Invalid password or email';
            }else{

                $response['status'] = 'success';
                $response['message'] = 'Logged in';
            }
            return json_encode($response);
        } catch (Throwable $err) {
            return $err;
        }
    }

}

