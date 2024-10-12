<?php
namespace App\Entity;

use Dotenv\Dotenv;
use Doctrine\ORM\EntityManagerInterface;
use Throwable;

require_once __DIR__ . '/../bootstrap.php';

$dotenv = Dotenv::createImmutable(__DIR__. "/../..");  
$dotenv->load();


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

    public function login($email, $password): string | bool | array | Throwable{
        try {
            $ADMIN_EMAIL = $_ENV['ADMIN_EMAIL'];
            $ADMIN_PASSWORD = $_ENV['ADMIN_PASSWORD'];
            $response = [
                'status' => '',
                'message' => ''
            ];
            
            $verify_password = $this->comparePassword($email, $password);
            if($ADMIN_EMAIL === $email && $ADMIN_PASSWORD === $password){
                $response['status'] = 'success';
                $response['message'] = 'Loged In as Admin';
                $response['redirect'] = '/src/views/index.html';
                setcookie('isAdmin', 'true', time() + 3600, '/');
            }else if($verify_password === 0){
                $response['status'] = 'error';
                $response['message'] = 'User not found';
            }else if(!$verify_password){
                $response['status'] = 'error';
                $response['message'] = 'Invalid password or email';
            }else{
                $response['status'] = 'success';
                $response['message'] = 'Logged in';
                $response['redirect'] = '/src/views/index.html';
            }
            return json_encode($response);
        } catch (Throwable $err) {
            return $err;
        }
    }

}

