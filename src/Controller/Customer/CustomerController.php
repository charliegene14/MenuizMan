<?php

namespace App\Controller\Customer;

use App\Manager\CustomerManager;
use App\Manager\PurchaseManager;
use App\Entity\Customer;

use App\Exception\SearchException;


class CustomerController {

    private static $customer;
    private static $purchases;
    private static $tickets;

    /**
     * Main controller for single customer page.
     *
     * @return void
     */
    public static function main() {

        global $user;
        
        $id = $_GET["id"];
        self::buildDisplayTable($id);
        $customer = self::$customer;
        include "views/customer.php";
        
    }

    /**
     * Set purchases on customer fetched
     *
     * @param integer $id
     * @return void
     */
    private static function buildDisplayTable(int $id) {
        self::$customer = CustomerManager::getOneBy(
            ["customerID" => $id]
           
        );
        
        if (self::$customer === []) {
            throw new SearchException ("Aucun utilisateur pour cet ID");
        }

       self::$purchases = CustomerManager::getCustomerPurchases(self::$customer);

       foreach(self::$purchases as $purchase) {
           self::$tickets[$purchase->getId()] = PurchaseManager::getPurchaseTickets($purchase);
           $purchase->setTickets(self::$tickets[$purchase->getId()]);
       }
       self::$customer->setPurchases(self::$purchases);
      
    } 

    public static function getCustomer() {
        return self::$customer;
    }

}