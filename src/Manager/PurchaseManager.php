<?php

namespace App\Manager;
use App\Entity\Purchase;
use App\Entity\Customer;
use App\Entity\City;
use App\Entity\Address;
use App\Manager\TicketManager;
use DateTime;

class PurchaseManager extends AbstractManager 
{
    public const TABLE = "purchase";
    public const JOINS = [
        "customer"=>"customer.customerID = purchase.customerID",
        "address" => "customer.addressID = address.addressID",
        "city" => [
            "city.COG = address.COG",
            "city.postCode = address.postCode"
        ]
    ];

    /**
     * Map each database row as object entity
     *
     * @param integer $purchaseID
     * @param integer $payment
     * @param string $purchaseDate
     * @param integer $purchaseInvoice
     * @param integer $customerID
     * @param integer $isaboutCustomerID
     * @param string $custLastName
     * @param string $custFirstName
     * @param string|null $phoneNumber
     * @param integer $addressID
     * @param integer $addAddressID
     * @param integer|null $streetNumber
     * @param string $streeName
     * @param string $COG
     * @param string $postCode
     * @param string $cityCOG
     * @param string $cityPostCode
     * @param string $cityName
     * @return Purchase
     */
    public static function rowMapper(
        int $purchaseID, 
        int $payment, 
        string $purchaseDate, 
        int $purchaseInvoice, 
        int $customerID,
        int $isaboutCustomerID,
        string $custLastName,
        string $custFirstName,
        ?string $phoneNumber=null,
        int $addressID,
        int $addAddressID,
        ?int $streetNumber=null,
        string $streeName,
        string $COG,
        string $postCode,
        string $cityCOG,
        string $cityPostCode,
        string $cityName
    ) : Purchase 
    {
        $city = new City ($COG, $postCode, $cityName);
        $address = new  Address ($city,$streeName, $streetNumber, $addressID);

        $customer = new Customer(
            $custLastName,
            $custFirstName,
            $phoneNumber,
            $address,
            $customerID
        );
        
        return new Purchase(
            $purchaseID, 
            $customer,
            PurchaseArticleManager::getBy(["purchaseID"=>$purchaseID]),
            $payment? true : false,
            $purchaseInvoice,
            new DateTime($purchaseDate),
            []
        );
    }

    /**
     * Insert a Database Purchase from a php entity Purchase
     *
     * @param Purchase $purchase
     * @return Purchase|null
     */
    public static function insert(Purchase $purchase) : ?Purchase {
        $str = "INSERT INTO ". self::TABLE . "(payment,purchaseDate,purchaseInvoice,customerID) VALUES (:payment,:purchaseDate,:purchaseInvoice,:customerID)";
        $query = self::db()->prepare($str);
        $tArticles=$purchase->getArticles();

        $query->bindValue("payment",$purchase->getPaymentStatus()? 1:0);
        $query->bindValue("purchaseDate",$purchase->getDate()->format("Y-m-d H:i:s"));
        $query->bindValue("purchaseInvoice",$purchase->getInvoice());
        $query->bindValue("customerID",$purchase->getCustomer()->getId());

        $exec = $query->execute();
        self::disconnect();

        if($exec) {
            $id = self::db()->query("SELECT MAX(purchaseID) as id FROM " . self::TABLE)->fetch()["id"];
            $createdPurchase = self::getOneBy(["purchaseID" => $id]);
            foreach($tArticles as $purchaseArticle) {
                d($purchaseArticle);
                PurchaseArticleManager::insert($purchaseArticle,$createdPurchase);
            }

            self::disconnect();
            return $createdPurchase;
        } 
        return null;
    }


    /**
     * Get all purchases in database from an entity Customer
     *
     * @param Purchase $purchase
     * @return array<Ticket>
     */
    public static function getPurchaseTickets(Purchase $purchase): array {
        return $tickets = TicketManager::getBy(["purchaseID" => $purchase->getId()]);
    }
}