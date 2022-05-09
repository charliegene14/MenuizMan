<?php

namespace App\Controller\Search;

use App\Manager\CustomerManager;
use App\Exception\SearchException;


class SearchCustomerController {


    /**
     * Controller for searching articles according to filters
     *
     * @param array $filters
     * @return void
     */
    public static function search(array $filters) {
        $attributes = [];
        foreach($filters as $key => $value) {
            $filters[$key] = htmlspecialchars($value);
        }

        if ($filters["custFirstName"] !== "") {
            if(strlen($filters["custFirstName"]) > 20 ) {
                throw new SearchException("Le prénom ne peut pas contenir plus de 20 caractères");
            } else {
                $attributes["custFirstName"] = $filters["custFirstName"];
            }
        }

        if ($filters["custLastName"] !== "") {
            if(strlen($filters["custLastName"]) > 20 ) {
                throw new SearchException("Le nom ne peut pas contenir plus de 20 caractères");
            } else {
                $attributes["custLastName"] = $filters["custLastName"];
            }
        }

        if ($filters["numTel"] !== "") {
            $reg ='^(?:(?:\+|00)33|0)\s*[1-9](?:[\s.-]*\d{2}){4}^';
            if(!preg_match($reg,$filters["numTel"])){
                throw new SearchException("Format numéro de téléphone incorrect");
            } else {
                $clearedTel = self::clearNumtel($filters["numTel"]);
                $attributes["phoneNumber"] = $clearedTel;

            }
        }

        if ($filters["purchaseID"] !== "") {
            if(is_nan($filters["purchaseID"])) {
                throw new SearchException("Le numéro de commande doit être un entier positif");
            } else {
                $attributes["purchaseID"] = $filters["purchaseID"];
            }
        }

        if ($filters["streetNumber"] !== "") {
            if(is_nan($filters["streetNumber"])) {
                throw new SearchException("Le numéro de commande doit être un entier positif");
            } else {
                $attributes["streetNumber"] = $filters["streetNumber"];
            }
        }

        if ($filters["streetName"] !== "") {
            if(strlen($filters["streetName"]) > 50 ) {
                throw new SearchException("Le nom de rue ne peut pas contenir plus de 50 caractères");
            } else {
                $attributes["streetName"] = $filters["streetName"];
            }
        }

        if ($filters["postCode"] !== "") {
            if(strlen($filters["postCode"]) > 5 ) {
                throw new SearchException("Le code postal ne peut pas contenir plus de 5 caractères");
            } else {
                $attributes["postCode"] = $filters["postCode"];
            }
        }

        if ($filters["cityName"] !== "") {
            if(strlen($filters["cityName"]) > 50 ) {
                throw new SearchException("Le nom de ville ne peut pas contenir plus de 50 caractères");
            } else {
                $attributes["cityName"] = $filters["cityName"];
            }
        }

        $resultset=self::buildCustomerDisplayTable(CustomerManager::searchBy($attributes));

        if(is_null($resultset)) {
            throw new SearchException ("Aucun résultat pour cette recherche");
        }
        return $resultset;
    }

    /**
     * Build the HTML table for display results
     *
     * @param array $customersArray
     * @return void
     */
    private static function buildCustomerDisplayTable(array $customersArray) {
        foreach ($customersArray as $customer){
            $table = [
                $customer->getFirstName() . " " . $customer->getLastName(),
                "<span class='bold'>Adresse : </span>" . $customer->getAddress()->__toString(),
                "<span class='bold'>Numéro de téléphone : </span>" . $customer->getPhoneNumber(),
                "?p=customer&id=".$customer->getId()
            ];
            
            $displayTable[] = $table;
        
        }

        if(isset($displayTable)) {
            return $displayTable;
        }
    
    }

    /**
     * Clean displaying tel number
     *
     * @param string $numTel
     * @return string
     */
    private static function clearNumtel(string $numTel) :string {
        $numTel = str_replace("+33","0",$numTel);
        $numTel = str_replace("0033","0",$numTel);
        $numTel = str_replace("-","",$numTel);
        $numTel = str_replace(".","",$numTel);
        $numTel = str_replace(" ","",$numTel);
      
        return $numTel;
    }

}