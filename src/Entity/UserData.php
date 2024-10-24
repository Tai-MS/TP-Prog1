<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
// use Dotenv\Dotenv;
use Doctrine\ORM\Mapping as ORM;
use Throwable;


// $dotenv = Dotenv::createImmutable(__DIR__. "/../..");  
// $dotenv->load();
// $SECRET_KEY = $_ENV['SECRET_KEY'];
#[ORM\Entity]
#[ORM\Table(name: "Usuarios")]
class UserData {
    private EntityManagerInterface $entityManager;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private $id;
    #[ORM\Column(type: "string")]
    protected string $name;

    #[ORM\Column(type: "string")]
    protected string $lastname;

    #[ORM\Column(type: "string")]
    protected string $email;

    #[ORM\Column(type: "string")]
    protected string $password;

    #[ORM\Column(type: "boolean")]
    protected bool $adminPrivileges;

    #[ORM\OneToMany(targetEntity: Ticket::class, mappedBy: 'user')]
    protected Collection $ticket_user;

    public function __construct(string $name, string $lastname, string $password, string $email, bool $adminPrivileges, EntityManagerInterface $entityManager) {
        $this->name = $name;
        $this->lastname = $lastname;
        $this->password = $password;
        $this->email = $email;
        $this->adminPrivileges = $adminPrivileges;
        $this->ticket_user = new ArrayCollection();
        $this->entityManager = $entityManager;
    }

    public function getName(): string {
        return $this->name;
    }
    public function getId(): ?int {
        return $this->id;
    }
    public function getLastname(): string {
        return $this->lastname;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function getPassword(): string {
        return $this->password;
    }

    public function emailExists(string $email): UserData | Throwable | null {
        try {
            $user_email = $this->entityManager->getRepository(UserData::class)
                ->findOneBy(['email' => $email]);
            
            return $user_email; 
        } catch (Throwable $err) {
            return $err; 
        }
    }
    
    public function setPassword(string $password): void{
        $this->password = $password;
    }

    public function hasAdminPrivileges(): bool {
        return $this->adminPrivileges;
    }

    public function addTicket(Ticket $ticket_user): self {
        if (!$this->ticket_user->contains($ticket_user)) {
            $this->ticket_user->add($ticket_user);
            $ticket_user->setUser($this);
        }
        return $this;
    }
}
