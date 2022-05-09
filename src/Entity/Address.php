<?php

namespace App\Entity;

class Address {

    /**
     *
     * @var integer
     */
    private $id;

    /**
     *
     * @var integer|null
     */
    private $streetNumber;

    /**
     * @var string
     */
    private $streetName;

    /**
     *
     * @var City
     */
    private $city;

    /**
     *
     * @param integer $id
     * @param integer|null $streetNumber
     * @param string $streetName
     * @param City $city
     * @param Customer $customer
     */
    public function __construct(
        City $city,
        string $streetName,
        int $streetNumber = null,
        int $id =null
    )
    {
        $this->setId($id);
        $this->setStreetNumber($streetNumber);
        $this->setStreetName($streetName);
        $this->setCity($city);
    }

    /**
     *
     * @param integer $id
     * @return void
     */
    private function setId(?int $id){
        if($id>=0) {
            $this->id=$id;
        }
    }
    /**
     *
     * @param integer $streetNumber
     * @return void
     */
    private function setStreetNumber(?int $streetNumber){
        if($streetNumber >=0 ){
            $this->streetNumber = $streetNumber;
        }
    }
    /**
     *
     * @param string $streetName
     * @return void
     */
    private function setStreetName(string $streetName){
        if(strlen($streetName)<=50){
            $this->streetName = $streetName;
        }
    }

    /**
     *
     * @param City $city
     * @return void
     */
    private function setCity(City $city){
        $this->city =$city;
    }

    /**
     *
     * @return integer|null
     */
    public function getId() : ?int {
        return $this->id;
    }

    /**
     *
     * @return integer|null
     */
    public function getStreetNumber() :?int {
        return $this->streetNumber;
    }

    /**
     *
     * @return string
     */
    public function getStreetName() : string {
        return $this->streetName;
    }

    /**
     *
     * @return City
     */
    public function getCity() : City {
        return $this->city;
    }

    /**
     *
     * @return string
     */
    public function __toString() : string {
        $msg = "$this->streetNumber $this->streetName " . $this->city->getPostCode() . " " . $this->city->getName();
        return $msg;
    }
}