<!-- ?php

require_once 'User.php';
use Doctrine\ORM\Mapping as ORM;

// Indicamos que esta clase constituye una entidad, que se traducirá en una
// tabla de la BD, llamada "empleados_permanentes":
#[ORM\Entity(repositoryClass: UserPersistenceRepository::class)]
#[ORM\Table(name: "empleados_permanentes")]
class UserAdmin extends User {
    // #[ORM\Id, ORM\Column(type:'integer')]
    // #[ORM\GeneratedValue]
    // private int|null $id = null;
    private $adminPrivileges;

    public function __construct($name, $lastname,$password, $email, $adminPrivileges) {
        parent::__construct($name, $lastname,$password, $email, $adminPrivileges);
        $this->adminPrivileges = $adminPrivileges;
    }

    

    public function getAdminPrivileges() {
        return $this->adminPrivileges;
    }

    public function setAdminPrivileges($privileges) {
        $this->adminPrivileges = $privileges;
    }
}

 -->
