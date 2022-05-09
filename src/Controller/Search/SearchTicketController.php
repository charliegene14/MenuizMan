<?php

namespace App\Controller\Search;

use DateTime;
use App\Entity\Ticket;
use App\Manager\TicketManager;
use App\Exception\SearchException;

class SearchTicketController {

    /**
     * Controller for searching tickets according to filters
     *
     * @param array $filters
     * @return void
     */
    public static function search(array $filters) {

        $attributes = [];
        foreach($filters as $key => $value) {
            $filters[$key] = htmlspecialchars($value);
        }
        
        if (isset($filters["ticketID"]) && $filters["ticketID"] !== "") {

            if(is_nan($filters["ticketID"])) {
                throw new SearchException("L'ID ticket doit être un entier positif");
            } else {
                $attributes["ticketID"] = $filters["ticketID"];
            }
        }

        if (isset($filters["purchaseID"]) && $filters["purchaseID"] !== "") {
            if(is_nan($filters["purchaseID"])) {
                throw new SearchException("Le numéro de commande doit être un entier positif");
            } else {
                $attributes["purchaseID"] = $filters["purchaseID"];
            }
        }

        if (isset($filters["custFirstName"]) && $filters["custFirstName"] !== "") {
            if(strlen($filters["custFirstName"]) > 20 ) {
                throw new SearchException("Le prénom ne peut pas contenir plus de 20 caractères");
            } else {
                $attributes["custFirstName"] = $filters["custFirstName"];
            }
        }

        if (isset($filters["custLastName"]) && $filters["custLastName"] !== "") {
            if(strlen($filters["custLastName"]) > 20 ) {
                throw new SearchException("Le nom ne peut pas contenir plus de 20 caractères");
            } else {
                $attributes["custLastName"] = $filters["custLastName"];
            }
        }

        if (isset($filters["startingTime"]) && $filters["startingTime"] !== "") {
            if(new DateTime() < new DateTime($filters["startingTime"])) { 
                throw new SearchException("Cette date est postérieure à la date du jour");

            } else {

                $origindate = strtotime($filters["startingTime"]);
                $attributes["startingTime"] = date('Y/m/d',$origindate);

                $resultset = self::buildTicketDisplayTable(TicketManager::searchWithDate($attributes));

                if(is_null($resultset)) {
                    throw new SearchException ("Aucun résultat pour cette recherche");
                }

                return $resultset;
            }
        }

        $resultset = self::buildTicketDisplayTable(TicketManager::searchBy($attributes));

        if(is_null($resultset)) {
            throw new SearchException ("Aucun résultat pour cette recherche");
        }
        return $resultset;
    }

    /**
     * Build the HTML table for display results
     *
     * @param array $ticketArray
     * @return void
     */
    private static function buildTicketDisplayTable(array $ticketArray){

        /**
         * @var Ticket
         */
        foreach($ticketArray as $ticket) {
            $userActions = $ticket->getActions();
            $closed = $ticket->isClosed();
            foreach($userActions as $userAction) {
                if($closed && $userAction->getAction()->getId()===7) {
                    $date = $userAction->getEnd()->format("d-m-Y H:i:s");
                } elseif ($userAction->getAction()->getId()===1){
                    $date = $userAction->getStart()->format("d-m-Y H:i:s");
                }
            }
           
            $table = [
                "Ticket n°" . $ticket->getId(),
                "<span class='bold'>Type : </span>" . $ticket->getType()->getId(),
                "<span class='bold'>Nom du client : </span>" . $ticket->getPurchase()->getCustomer()->getFirstName() . " " . $ticket->getPurchase()->getCustomer()->getLastName(),
                "<span class='bold'>Commande n° </span>" . $ticket->getPurchase()->getId(),
                $ticket->getArticle()?"<span class='bold'>Article n° </span>" . $ticket->getArticle()->getId():null,
                $ticket->getArticle()?"<span class='bold'>Article : </span>" . $ticket->getArticle()->getName():null,
                $ticket->isClosed()?"<span class='bold'>Résolu :</span> Oui":"<span class='bold'>Résolu :</span> Non",
                $ticket->isClosed()?"<span class='bold'>Date de clôture : $date</span> ":"<span class='bold'> Date de création : $date</span>",
                "?p=ticket&action=show&id=".$ticket->getId()
                
            ];
            $displayTable[] = $table;
            
        }
        //d($displayTable);
        if(isset($displayTable))
            return $displayTable;
    }

    /**
     * Make a quick ticket search by ID
     * Call from AJAX query
     * 
     * @param string $id
     * @return array|null
     */
    public static function quickSearch(string $id): ?array {

        if ($id === "") return [];
        
        $tickets = TicketManager::searchBy(["ticketID" => $id]);
        $ids = [];

        /**
         * @var Ticket
         */
        foreach ($tickets as $ticket) {
            $ids[] = $ticket->getId();
        }

        return $ids;
    }
}