<?php

namespace App\Controller\Search;

use DateTime;
use App\Entity\Purchase;
use App\Manager\PurchaseManager;
use App\Exception\SearchException;

class SearchPurchaseController {

    /**
     *  Controller for searching purchases according to filters
     *
     * @param array $filters
     * @return void
     */
    public static function search(array $filters) {
        $attributes = [];
        foreach($filters as $key => $value) {
            $filters[$key] = htmlspecialchars($value);
        }

        if ($filters["purchaseID"] !== "") {
            if (is_nan($filters["purchaseID"]) || $filters["purchaseID"] < 0)
                throw new SearchException("L'ID commande doit être un entier positif");

            $attributes["purchaseID"] = $filters["purchaseID"];
        }

        if ($filters["custFirstName"] !== "") {
            if(strlen($filters["custFirstName"]) > 20 )
                throw new SearchException("Le prénom ne peut pas contenir plus de 20 caractères");

            $attributes["custFirstName"] = $filters["custFirstName"];
        }

        if ($filters["custLastName"] !== "") {
            if(strlen($filters["custLastName"]) > 20 )
                throw new SearchException("Le nom ne peut pas contenir plus de 20 caractères");

            $attributes["custLastName"] = $filters["custLastName"];
        }

        if ($filters["purchaseInvoice"] !== "") {
            if (is_nan($filters["purchaseInvoice"]) || $filters["purchaseInvoice"] < 0)
                throw new SearchException("Le numéro de facture doit être un entier positif");

            $attributes["purchaseInvoice"] = $filters["purchaseInvoice"];
        }

        if ($filters["purchaseDate"] !== "") {

            if(new DateTime() < new DateTime($filters["purchaseDate"])) 
                throw new SearchException("Cette date est postérieure à la date du jour");

            $attributes["purchaseDate"] = $filters["purchaseDate"];
        }

        $resultset = self::buildPurchaseDisplayTable(PurchaseManager::searchBy($attributes));

        if(is_null($resultset)) 
            throw new SearchException ("Aucun résultat pour cette recherche");

        return $resultset;
    }

    /**
     * Build the HTML table for display results
     *
     * @param array $purchases
     * @return void
     */
    private static function buildPurchaseDisplayTable(array $purchases) {
        
        /**
         * @var Purchase
         */
        foreach ($purchases as $purchase) {

            $table = [
                "Commande n°" . $purchase->getId(),
                "<span class='bold'>Client : </span>" . $purchase->getCustomer()->getFirstName() . " " . $purchase->getCustomer()->getLastName(),
                "<span class='bold'>Date : </span>" . $purchase->getDate()->format("d/m/Y H:i:s"),
                $purchase->getPaymentStatus() ? "<span class='bold'>Etat paiement : </span> Payé" : "<span class='bold'>Etat paiement : </span> Non payé",
                "<span class='bold'>Facture n° </span>" . $purchase->getInvoice(),
                "?p=purchase&action=show&id=" . $purchase->getId()
            ];

            $displayTable[] = $table;
        }

        if(isset($displayTable))
            return $displayTable;
    }

}