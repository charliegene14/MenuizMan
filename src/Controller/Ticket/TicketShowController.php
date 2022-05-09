<?php
namespace App\Controller\Ticket;
use DateTime;
use Exception;
use App\Entity\City;
use App\Entity\Ticket;
use App\Entity\Address;
use App\Entity\Customer;
use App\Entity\TicketType;
use App\Entity\UserAction;
use App\Manager\UserManager;
use App\Manager\ActionManager;
use App\Manager\TicketManager;
use App\Manager\ArticleManager;
use App\Manager\PurchaseManager;
use App\Manager\TicketTypeManager;
use App\Manager\UserActionManager;
use App\Exception\NotFoundException;
use App\Manager\CustomerManager;
use App\Controller\TicketController;

class TicketShowController {

    /**
     * Controler showing the ticket
     *
     * @param integer $id
     * @return void
     */
    public static function show(int $id) {
        global $user ;
     
        $ticket = TicketManager::getOneBy(["ticketID" => $id]);

        if (!$ticket) throw new NotFoundException();

        $id = $ticket->getId();
        $purchase = $ticket->getPurchase()->getId();
        $type = $ticket->getType()->getName();
        $comment = $ticket -> getCommentary();
        $actions = $ticket -> getActions();
        $closed = $ticket->isClosed();       
        $article = $ticket->getArticle()?$ticket->getArticle()->getId():null;

        include "views/ticket.php";
    }

}