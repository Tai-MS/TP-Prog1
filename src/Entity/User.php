<!-- ?php

namespace App\Entity;
require_once __DIR__ . '/../bootstrap.php';
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "Usuarios")]
class User extends UserData {
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private $id;

    #[ORM\Column(type: "string")] 
    protected string $password;  

    public function __construct(string $name, string $lastname, string $password, string $email, bool $adminPrivileges) {
        parent::__construct($name, $lastname, $password, $email, $adminPrivileges);
    }

    public function getId(): ?int {
        return $this->id;
    }

    // Getters y Setters
    public function setPassword(string $password): self {
        $this->password = $password;
        return $this;
    }

    public function getPassword(): string {
        return $this->password;
    }
} -->