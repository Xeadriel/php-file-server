<?php 

class User{
    private string $username;
    private string $password;
    private string $email;

    function __construct(string $username, string $password, string $email){
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
    }
    public function getUsername(): string{
        return $this->username;
    }
    public function getPassword(): string{
        return $this->password;
    }

    public function getEmail(): string{
        return $this->email;
    }
}