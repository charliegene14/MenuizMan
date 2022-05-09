<?php

namespace App\Manager;

use App\Entity\City;
use App\Entity\Address;
use App\Entity\Customer;
use App\Entity\Purchase;
use App\Manager\PurchaseManager;
use App\Exception\ManagerException;

class CustomerManager extends AbstractManager {

    public const TABLE = "customer";

    public const JOINS = [
        "address" => "customer.addressID = address.addressID",
        "city" => [
            "city.COG = address.COG",
            "city.postCode = address.postCode"
        ]
    ];

    /**
     * Map each database row as object entity
     *
     * @param integer $id
     * @param string $lastName
     * @param string $firstName
     * @param string|null $phoneNumber
     * @param integer $addressID
     * @param integer $addr_addressID
     * @param integer $addr_streetNumber
     * @param string $addr_streetName
     * @param string $addr_COG
     * @param string $addr_postCode
     * @param string $city_COG
     * @param string $city_postCode
     * @param string $cityName
     * @return void
     */
    public static function rowMapper(
        int $id,
        string $lastName,
        string $firstName,
        ?string $phoneNumber = NULL,
        int $addressID,
        int $addr_addressID,
        int $addr_streetNumber,
        string $addr_streetName,
        string $addr_COG,
        string $addr_postCode,
        string $city_COG,
        string $city_postCode,
        string $cityName
    )
    {

        $city       = new City($city_COG, $city_postCode, $cityName);
        $address    = new Address($city, $addr_streetName, $addr_streetNumber, $addr_addressID);
        
        return new Customer(
            $lastName,
            $firstName,
            $phoneNumber,
            $address,
            $id
        );   
    }

    /**
     *
     * @param array $attributes
     * @return Customer|null
     */
    public static function getOneBy(array $attributes): ?object {
        return parent::getOneBy($attributes);
    }

    /**
     * Get all purchases from a single customer
     *
     * @param Customer $customer
     * @return array<Purchase>|null
     */
    public static function getPurchases(Customer $customer) :array {

        return PurchaseManager::getBy(["purchase.customerID" => $customer->getId()]);
    } 

    /**
     * Update a Database Article from a php entity Article
     *
     * @param Customer $customer
     * @return Customer|null
     */
    public static function update(Customer $customer) : ?Customer {
        $str = "UPDATE " . self::TABLE . " SET 
        custLastName=:custLastName, 
        custFirstName=:custFirstName, 
        phoneNumber=:phoneNumber,
        addressID=:addressID 
        WHERE customerID=:customerID";
        $query = self::db()->prepare($str);
        $query->bindValue("custLastName",$customer->getLastName());
        $query->bindValue("custFirstName",$customer->getFirstName());
        $query->bindValue("phoneNumber",$customer->getPhoneNumber());
        $query->bindValue("addressID",$customer->getAddress()->getId());
        $query->bindValue("customerID",$customer->getId());

        $exec = $query->execute();
        
        if($exec) {
            self::disconnect();
            return $customer;
        }
        
        self::disconnect();
        return null;
    }

    /**
     * Get a Customer from Databse with filters attributes
     *
     * @param array $attributes
     * @param array|null $orderBy
     * @return array
     */
    public static function searchBy(array $attributes, ?array $orderBy = null): array {

        if ($attributes === []) throw new ManagerException("Impossible d'effectuer une recherche sans filtres");

        $str = "SELECT c.customerID, c.custLastName, c.custFirstName, c.phoneNumber, c.addressID, a.addressID, a.streetNumber,
        a.streetName, a.COG, a.postCode, city.COG, city.postCode, city.cityName FROM " . get_called_class()::TABLE;
        $str .= " c JOIN address a ON a.addressID = c.addressID JOIN purchase p ON p.customerID=c.customerID JOIN city ON city.COG=a.COG AND city.postCode = a.postCode"; 
        
        $str .= " WHERE 1 = 1";

        foreach ($attributes as $attribute => $value) {
            $str .= " AND UPPER(" . $attribute . ") LIKE CONCAT('%',UPPER(:" . $attribute . "),'%')" ;
        }
        $str .= " GROUP BY customerID";

        $query = self::db()->prepare($str);

        foreach($attributes as $attribute => $value) {
            
            $query->bindValue(
                $attribute,
                $value    
            );
        }

        $query->execute();
        return self::mapper($query);
    }


    /**
     * Get all purchases in database from an entity Customer
     *
     * @param Customer $customer
     * @return array<Purchase>
     */

    public static function getCustomerPurchases(Customer $customer) : array {

        if (is_null($customer)) throw new ManagerException("Ce client n'existe pas");
    
        $str = "SELECT p.purchaseID,p.payment,p.purchaseDate,p.purchaseInvoice,p.customerID,c.customerID,c.custLastName,
        c.custFirstName,c.phoneNumber,c.addressID,a.addressID,a.streetNumber,a.streetName,a.COG,a.postCode,ci.COG,ci.postCode,ci.cityName
        FROM purchase p JOIN customer c ON c.customerID = p.customerID JOIN address a ON a.addressID=c.addressID JOIN city ci 
        ON ci.COG = a.COG AND ci.postCode = a .postCode";

        $str .= " WHERE p.customerID = :customerID";
        $query =self::db()->prepare($str);
        $query->bindValue("customerID",$customer->getId());
        
        $query->execute();
        
        return PurchaseManager::mapper($query);
    }
}