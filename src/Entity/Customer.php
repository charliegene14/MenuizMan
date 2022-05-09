<?php

namespace App\Entity;

class Customer {

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $lastName;

    /**
     * @var string
     */
    private $firstName;


    /**
     * @var string|null
     */
    private $phoneNumber;

    /**
     * @var Address|null
     */
    private $address;

    /**
     *
     * @var array<Purchase>
     */
    private $purchases = [];

    /**
     *
     * @param integer $id
     * @param string $lastName
     * @param string $firstName
     * @param string|null $phoneNumber
     */
    public function __construct(
        
        string $lastName,
        string $firstName,
        string $phoneNumber = null,
        ?Address $address = null,
        ?int $id=null
       
    ){
        $this->setId($id);
        $this->setFirstName($firstName);
        $this->setLastName($lastName);
        $this->setPhoneNumber($phoneNumber);
        $this->setAddress($address);
    }

    /**
     *
     * @param integer $id
     * @return void
     */
    private function setId(int $id) {
        if($id>=0) {
            $this->id = $id;
        }
    }

    /**
     *
     * @param string $firstName
     * @return void
     */
    private function setFirstName(string $firstName){
        if (strlen($firstName)<= 20) {
            $this->firstName = $firstName;
        }
    }

    /**
     *
     * @param string $lastName
     * @return void
     */
    private function setLastName(string $lastName){
        if (strlen($lastName)<= 20) {
            $this->lastName = $lastName;
        }
    }

    /**
     *
     * @param integer $phoneNumber
     * @return void
     */
    public function setPhoneNumber(?string $phoneNumber = NULL){

        $this->phoneNumber = $phoneNumber;
       
    }

    /**
     *
     * @param array<Address> $addresses
     * @return void
     */
    public function setAddress(?Address $address = null): void {
        $this->address = $address;
    }

    /**
     * 
     *
     * @param array $purchases
     * @return void
     */
    public function setPurchases(array $purchases) : void {
        $this->purchases = $purchases;
    }

    /**
     * 
     *
     * @return integer|null
     */
    public function getId() : ?int {
        return $this->id;
    }

    /**
     * 
     *
     * @return string
     */
    public function getLastName() : string {
        return $this->lastName;
    }

    /**
     * 
     *
     * @return string
     */
    public function getFirstName() : string {
        return $this->firstName;
    }

    /**
     * 
     *
     * @return integer|null
     */
    public function getPhoneNumber() : ?int {
        return $this->phoneNumber;
    }

    /**
     * 
     *
     * @return Address|null
     */
    public function getAddress(): ?Address {
        return $this->address;
    }

    /**
     * 
     *
     * @return array|null
     */
    public function getPurchases(): ?array {
        return $this->purchases;
    }

    /**
     * 
     *
     * @return string
     */
    public function getFullName() : string {
        return $this->firstName . " " . $this->lastName;
    }
}