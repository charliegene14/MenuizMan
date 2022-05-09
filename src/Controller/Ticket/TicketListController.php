<?php

namespace App\Controller\Ticket;

use App\Manager\TicketManager;

class TicketListController
{

    /**
     * Main ticket lists controller
     *
     * @return void
     */
    public static function main() {

        $action = isset($_GET["action"]) ? $_GET["action"] : null;

        switch ($action) {

            case "to_diag":
                self::toDiagnostic();
                break;

            case "to_ship":
                self::toShip();

                break;

            case "closed":
                self::closed();
                break;

            default:
                self::home();
        }

    }

    /**
     * Home controller
     *
     * @return void
     */
    public static function home() {

        global $user;

        $urgentTickets = TicketManager::getBy([
            "urgent" => 1,
            "closed" => 0
        ]);

        $inProgressTickets = TicketManager::getBy([
            "urgent" => 0,
            "closed" => 0
        ]);

        include "views/home.php";
    }

    /**
     * Show Tickets needing diagnotstic action
     *
     * @return void
     */
    public static function toDiagnostic() {

        global $user;
        $pageTitle = "Tickets à diagnostiquer";
        $ticketList = TicketManager::getToDiagnostic();

        include "views/tickets.php";
    }

    /**
     * Show tickets needing ship action
     *
     * @return void
     */
    public static function toShip() {

        global $user;
        $pageTitle = "Tickets à expédier";
        $ticketList = TicketManager::getToShip();

        
        include "views/tickets.php";
    }

    /**
     * Show closed tickets
     *
     * @return void
     */
    public static function closed() {

        global $user;
        $pageTitle = "Tickets terminés";
        $ticketList = TicketManager::getBy([
            "closed" => 1
        ]);

        include "views/tickets.php";
    }
}