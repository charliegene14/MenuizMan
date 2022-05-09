<?php

namespace App\Entity;
use App\Entity\Role;

class User {
    
    /**
     *
     * @var int
     */
    private $id;

    /**
     *
     * @var string
     */
    private $firstName;

    /**
     *
     * @var string
     */
    private $lastName;

    /**
     *
     * @var Role
     */
    private $role;

    /**
     *
     * @var string
     */
    private $login;

    /**
     *
     * @var string
     */
    private $password;

    /**
     *
     *
     * @param string $firstName
     * @param string $lastName
     * @param Role $role
     * @param string $login
     * @param string $password
     * @param integer|null $id
     */
    public function __construct(
        
        string $firstName,
        string $lastName,
        Role $role,
        string $login,
        string $password,
        ?int $id = null
    )
    {
        $this->setId($id);
        $this->setFirstName($firstName);
        $this->setlastName($lastName);
        $this->setRole($role);
        $this->setLogin($login);
        $this->setPassword($password);
    }


    /**
     *
     * @param integer $id
     * @return void
     */
    private function setId(?int $id = null): void {
        $this->id = $id;
    }

    /**
     *
     * @param string $firstName
     * @return void
     */
    public function setFirstName(string $firstName): void {
        $this->firstName = $firstName;
    }

    /**
     *
     * @param string $lastName
     * @return void
     */
    public function setLastName(string $lastName): void {
        $this->lastName = $lastName;
    }

    /**
     *
     * @param Role $role
     * @return void
     */
    public function setRole(Role $role): void {
        $this->role = $role;
    }

    /**
     *
     * @param string $login
     * @return void
     */
    public function setLogin(string $login): void {
        $this->login = $login;
    }

    /**
     *
     * @param string $password
     * @return void
     */
    public function setPassword(string $password): void {
        $this->password = $password;
    }

    /**
     * 
     *
     * @return integer
     */
    public function getId(): int { return $this->id; }

    /**
     * 
     *
     * @return string
     */
    public function getFirstName(): string { return $this->firstName; }

    /**
     * 
     *
     * @return string
     */
    public function getLastName(): string { return $this->lastName; }

    /**
     * 
     *
     * @return Role
     */
    public function getRole(): Role { return $this->role; }

    /**
     * 
     *
     * @return string
     */
    public function getLogin(): string { return $this->login; }

    /**
     * 
     *
     * @return string
     */
    public function getPassword(): string { return $this->password; }

    /**
     * 
     *
     * @param string $hash
     * @return void
     */
    public function updatePassword(string $hash): void {
        $this->setPassword($hash);
    }

}