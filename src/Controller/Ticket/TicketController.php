<?php

namespace App\Controller\Ticket;

use App\Exception\NotFoundException;
use App\Manager\TicketManager;
use Exception;

class TicketController
{

    /**
     * Main controller for ticket's page. Actions:
     * + show 
     * + create
     * + doTask
     * + endTask
     * + leaveTask
     * + changeTask
     * + choice
     * + close
     * + urgent
     *
     * @return void
     */
    public static function main() {
        
        global $user;

        $action = isset($_GET["action"]) ? $_GET["action"] : null;

        switch ($action) {

            case "create":
                if ($user->getRole()->getId() !== "AST" && $user->getRole()->getId() !== "HLT")
                    throw new NotFoundException();

                TicketCreateController::create();
                break;

            case "show":
                if (!isset($_GET["id"]) || empty($_GET["id"])) {
                    throw new NotFoundException();
                } 
                
                TicketShowController::show($_GET["id"]);
                break;

            case "doTask":
                if ($user->getRole()->getId() !== "AST")
                    throw new NotFoundException();

                if(!isset($_GET["doID"]) || empty($_GET["doID"])) {
                    throw new NotFoundException();
                }
                
                TicketTaskController::doTask($_GET["doID"]);
                break;

            case "endTask":
                if ($user->getRole()->getId() !== "MNG" && $user->getRole()->getId() !== "AST")
                    throw new NotFoundException();

                if(!isset($_GET["doID"]) || empty($_GET["doID"])) {
                    throw new NotFoundException();
                }
                TicketTaskController::endTask($_GET["doID"]);
                break;   
            case "leaveTask":
                if ($user->getRole()->getId() !== "MNG" && $user->getRole()->getId() !== "AST")
                    throw new NotFoundException();

                if(!isset($_GET["doID"]) || empty($_GET["doID"])) {
                    throw new NotFoundException();
                }
                TicketTaskController::leaveTask($_GET["doID"]);
                break; 
            case "changeTask":
                if ($user->getRole()->getId() !== "MNG" && $user->getRole()->getId() !== "AST")
                    throw new NotFoundException();

                if(!isset($_GET["doID"]) || empty($_GET["doID"])) {
                    throw new NotFoundException();
                }
                TicketTaskController::changeTask($_GET["doID"]);
                break;

            case "choice":
                if($user->getRole()->getId() !== "AST") throw new NotFoundException();

                if(!isset($_POST["newTask"]) || !isset($_POST["ticketID"])) {
                    throw new NotFoundException();
                }    
                TicketTaskController::chooseTask($_POST["newTask"],$_POST["ticketID"]);
                break;
            case "close":
                if ($user->getRole()->getId() !== "MNG" && $user->getRole()->getId() !== "AST")
                    throw new NotFoundException();

                if(!isset($_GET["id"]) || empty($_GET["id"])) {
                    throw new NotFoundException();
                } 
                TicketTaskController::closeTask($_GET["id"]);
                break;

            case "urgent":
                if ($user->getRole()->getId() !== "MNG")
                    throw new NotFoundException();

                if(!isset($_GET["id"]) || empty($_GET["id"])) 
                    throw new NotFoundException();
                
                $ticket = TicketManager::getOneBy(["ticketID" => intval($_GET["id"])]);

                if (!$ticket)
                    throw new NotFoundException();

                $ticket->isUrgent() ? $ticket->setIsUrgent(false) : $ticket->setIsUrgent(true);

                $exec = TicketManager::update($ticket);

                if ($exec) {
                    header("location: ./?p=ticket&action=show&id=" . $ticket->getId());
                    exit();
                }

                throw new Exception("Impossible de mettre à jour le ticket en BDD."); 

                break;

            default:
                throw new NotFoundException();
        }

    }
}