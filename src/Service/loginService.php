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

    public function __construct(EntityManagerInterface $entityManager, $email, $password) {
        $this->entityManager = $entityManager;
    }


}