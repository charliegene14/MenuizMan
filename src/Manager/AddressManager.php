<?php

namespace App\Manager;

use App\Entity\City;
use App\Entity\Address;
use App\Exception\ManagerException;

class AddressManager extends AbstractManager {
    
    public const TABLE = "address";

    public const JOINS = [
        "city" => [
            "city.COG = address.COG",
            "city.postCode = address.postCode"
        ]
    ];

    /**
     * Map each fetched rows according to the object entity arguments
     *
     * @param integer $id
     * @param integer $streetNumber
     * @param string $streetName
     * @param string $addrCOG
     * @param string $addrPostCode
     * @param string $cityCOG
     * @param string $cityPostCode
     * @param string $cityName
     * @return Address
     */
    public static function rowMapper(
        int $id,
        int $streetNumber,
        string $streetName,
        string $addrCOG,
        string $addrPostCode,
        string $cityCOG,
        string $cityPostCode,
        string $cityName

    ): Address {

        $city = new City($cityCOG, $cityPostCode, $cityName);
 
        return new Address(
            $city,   
            $streetName,
            $streetNumber,
            $id
        );
    }

    /**
     * Insert a Database Address from a php entity Address
     *
     * @param Address $address
     * @return Address|null
     */
    public static function insert(Address $address): ?Address {

        $str = "INSERT INTO " . self::TABLE . "(streetName,COG,postCode,streetNumber) VALUES (:streetName,:COG,:postCode,:streetNumber)";
        $query = self::db()->prepare($str);
        $query->bindValue("streetName",$address->getStreetName());
        $query->bindValue("COG",$address->getCity()->getCog());
        $query->bindValue("postCode",$address->getCity()->getPostCode());
        if($address->getStreetNumber()){
            $query->bindValue("streetNumber",$address->getStreetNumber());
        } else {
            $query->bindValue("streetNumber",NULL);
        }

        $exec = $query->execute();
    
        $id = self::db()->query("SELECT LAST_INSERT_ID() as id FROM address")->fetch()["id"];
        
        self::disconnect();

        if ($exec)
            return self::getOneBy(["addressID" => $id]);

        return null;
    }

    /**
     * Update a Database Address from a php entity Address
     *
     * @param Address $address
     * @return void
     */
    public static function update(Address $address) {
        $str ="UPDATE " . self::TABLE . " SET streetNumber=:streetNumber, streetName=:streetName, COG=:COG, postCode =:postCode WHERE addressID=:id";
        $query = self::db()->prepare($str);
        $query->bindValue("streetName",$address->getStreetName());
        $query->bindValue("COG",$address->getCity()->getCog());
        $query->bindValue("postCode",$address->getCity()->getPostCode());
        if($address->getStreetNumber()){
            $query->bindValue("streetNumber",$address->getStreetNumber());
        } else {
            $query->bindValue("streetNumber",NULL);
        }
        if($address->getId()) {
            $query->bindValue("id",$address->getId());
        } else {
            throw new ManagerException ("Impossible de trouver cette adresse en Base de données");
        }
        $query->execute();
        self::disconnect();
    }

    /**
     *
     * @param array $attributes
     * @return Address|null
     */
    public static function getOneBy(array $attributes): ?object {
        return parent::getOneBy($attributes);
    }
}