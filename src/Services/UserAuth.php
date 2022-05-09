<?php

namespace App\Services;
use App\Entity\Role;

class UserAuth
{

    /**
     *
     * @var int
     */
    private $id;

    /**
     *
     * @var string
     */
    private $token;

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
     * @param string $firstName
     * @param string $lastName
     * @param Role $role
     */
    public function __construct(
        int $id,
        string $token,
        string $firstName,
        string $lastName,
        Role $role
    )
    {
        $this->setId($id);
        $this->setToken($token);
        $this->setFirstName($firstName);
        $this->setLastName($lastName);
        $this->setRole($role);
    }
    
    /**
     * 
     *
     * @param string $token
     * @return void
     */
    private function setToken(string $token) {
        $this->token = $token;
    }

    /**
     * 
     *
     * @param integer $id
     * @return void
     */
    private function setId(int $id): void {
        $this->id = $id;
    }

    /**
     * 
     *
     * @param string $firstName
     * @return void
     */
    private function setFirstName(string $firstName): void {
        $this->firstName = $firstName;
    }

    /**
     * 
     *
     * @param string $lastName
     * @return void
     */
    private function setLastName(string $lastName): void {
        $this->lastName = $lastName;
    }

    /**
     * 
     *
     * @param Role $role
     * @return void
     */
    private function setRole(Role $role): void {
        $this->role = $role;
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
    public function getToken(): string { return $this->token; }
}