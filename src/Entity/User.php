<!-- ?php

    namespace App\Entity;

    require_once __DIR__ . '/../bootstrap.php';

    use Doctrine\Common\Collections\Collection;
    use Doctrine\ORM\Mapping as ORM;

    #[ORM\Entity]
    #[ORM\Table(name: "Usuarios")]
    class User extends UserData {

        #[ORM\OneToMany(targetEntity: tickets::class, mappedBy: 'tickets')]
        public Collection|null $user_tickets = null;

        public function __construct(string $name, string $lastname, string $password, string $email, bool $adminPrivileges) {
            parent::__construct($name, $lastname, $password, $email, $adminPrivileges);
        }

        // Getters y Setters
        public function setPassword(string $password): self {
            $this->password = $password;
            return $this;
        }
    } -->
