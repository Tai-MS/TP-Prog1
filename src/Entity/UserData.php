<?php

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;

class UserData {
    #[ORM\Column(type: "string")]
    protected string $name;
    #[ORM\Column(type: "string")]
    protected string $lastname;
    #[ORM\Column(type: "string")]
    protected string $email;
    #[ORM\Column(type: "string")]
    protected string $password;
    // #[ORM\Column(type: "bool")]
    protected bool $adminPrivileges;

    public function __construct(string $name, string $lastname, string $password, string $email, bool $adminPrivileges) {
        $this->name = $name;
        $this->lastname = $lastname;
        $this->password = $password;
        $this->email = $email;
        $this->adminPrivileges = $adminPrivileges;
    }

    public function getName(): string {
        return $this->name;
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

    public function hasAdminPrivileges(): bool {
        return $this->adminPrivileges;
    }
}
