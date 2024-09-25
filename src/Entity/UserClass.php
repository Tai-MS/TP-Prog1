<?php


class user {

    protected string $name;
    protected string $lastname;
    protected string $email;
    protected string $password;

    public function __construct($name, $lastname, $email, $password)
    {
        $this->name = $name;
        $this->lastname = $lastname;
        $this->email = $email;
        $this->password = $password;
    }


    
}