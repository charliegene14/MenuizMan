<?php
namespace App\Controller\Ticket;

use DateTime;
use App\Entity\UserAction;
use App\Manager\UserManager;
use App\Manager\ActionManager;
use App\Manager\TicketManager;
use App\Manager\UserActionManager;
use App\Exception\ManagerException;
use App\Exception\NotFoundException;
use App\Manager\ArticleManager;
use Exception;

class TicketTaskController {

    /**
     * Controller when a user select a task to do
     *
     * @param integer $id
     * @return void
     */
    public static function doTask(int $id) {

        global $user;

        $ticket     = TicketManager::getOneBy(["ticketID" => $_GET["ticketID"]]);
        $currentUser = UserManager::getOneBy(["userID"=>$user->getId()]);

        $userAction = UserActionManager::getOneBy(["doID"=>$id]);

        if (!$ticket || !$userAction) throw new NotFoundException();

        if ($userAction->onDoing()) throw new Exception("L'action est déjà en cours de traitement");

        $userAction->setUser($currentUser);
        $userAction->setDatetimeStart(new DateTime());

        if ($userAction->getAction()->getId() === 5) {

            if (isset($_GET["replaceID"]) && $_GET["replaceID"] != $ticket->getId() && $_GET["replaceID"] !== "") {

                $replacement = ArticleManager::getOneBy(["articleID" => $_GET["replaceID"]]);
                if (!$replacement) {
                    header("Location: ./?p=ticket&action=show&id=" . $_GET["ticketID"] . "&replace_err=true");
                    exit();
                }

                $userAction->setCommentary("Remplacement par: ". $_GET["replaceID"]);

            } else {

                $userAction->setCommentary("Remplacement par: ". $ticket->getArticle()->getId());
            }
        }
        
        $exec = UserActionManager::update($userAction);

        if($exec) {
            header("location: ./?p=ticket&action=show&id=" . $_GET["ticketID"]);
            exit();
        } else {
            throw new ManagerException ("Impossible de mettre à jour la BDD");
        }
    }

    /**
     * Controller when a user end a task
     *
     * @param integer $id
     * @return void
     */
    public static function endTask(int $id) {

        global $user;
        $userAction = UserActionManager::getOneBy(["doID"=>$id]);

        if (!$userAction) throw new NotFoundException();

        if ($user->getRole()->getId() !== "MNG" && $user->getId() !== $userAction->getUser()->getId())
            throw new NotFoundException();

        if ($userAction->isDone()) throw new Exception("Cette action a déjà été réalisée.");

        $userAction->setDatetimeEnd(new DateTime());

        $exec = UserActionManager::update($userAction);

        if($exec) {
            header("location:?p=ticket&action=show&id=" . $_GET["ticketID"]);
            exit();
        } else {
            throw new ManagerException("Impossible de mettre à jour la BDD");
        }
    }

    /**
     * Controller for leaving task
     *
     * @param integer $id
     * @return void
     */
    public static function leaveTask(int $id) {

        global $user;

        $currentUser = UserManager::getOneBy(["userID"=>$user->getId()]);
        $userAction = UserActionManager::getOneBy(["doID"=>$id]);

        if ($userAction->getUser()->getId() !== $user->getId() && $user->getRole()->getId() !== "MNG") throw new NotFoundException();

        if ($userAction->isDone()) throw new Exception("Impossible d'abandonner une tâche terminée");

        $userAction->setUser(null);
        $userAction->setDatetimeStart(null);
        $exec = UserActionManager::update($userAction);

        if($exec) {
            header("location:?p=ticket&action=show&id=" . $_GET["ticketID"]);
            exit();
        } else {
            throw new ManagerException ("Impossible de mettre à jour la BDD");
        }
    }

    /**
     * Controller for changing last task
     *
     * @param integer $id
     * @return void
     */
    public static function changeTask(int $id) {
        
        
        $exec = UserActionManager::changeTask($_GET["ticketID"]);

        if($exec) {
            header("location:?p=ticket&action=show&id=" . $_GET["ticketID"]);
            exit();
        } else {
            throw new ManagerException ("Impossible de mettre à jour la BDD");
        }
    }

    /**
     * Controller when a user choose the next task
     *
     * @param integer $newTask
     * @param integer $ticketID
     * @return void
     */
    public static function chooseTask(int $newTask, int $ticketID) {

        global $user;

        $ticket = TicketManager::getOneBy(["ticketID" => $ticketID]);
        $action = ActionManager::getOneBy(["actionID"=> $newTask]);
        $currentUser = UserManager::getOneBy(["userID"=>$user->getId()]); 

        $userAction = new UserAction($action, $currentUser);

        if ($ticket->getType() !== "NP" && $ticket->getType() !== "NPAI") {
            if ($newTask === 4) {
                $userAction->setCommentary("Remboursement de ". ($ticket->getArticle()->getPrice() / 100) * $ticket->getTreatedQty() . "€");
            }
        }

        if ($newTask === 6) {
            $userAction->setCommentary(
                "Réexpédition à: ". $ticket->getPurchase()->getCustomer()->getAddress()
            );
        }
            
        if ($newTask === 2) {
            $userAction->setCommentary(
                $ticket->getArticle() ? "Réf. article n°".$ticket->getArticle()->getId() . " (x ". $ticket->getTreatedQty() .")" : "Toute la commande"
            );
        }

        $exec = UserActionManager::insert($userAction,$ticketID);

        if($exec) {
            header("location: ./?p=ticket&action=show&id=" . $ticketID);
            exit();
        } else {
            throw new ManagerException ("Impossible de mettre à jour la BDD");
        }
    }

    /**
     * Controller when a user close the ticket
     *
     * @param integer $ticketID
     * @return void
     */
    public static function closeTask(int $ticketID) {
        global $user;

        $action = ActionManager::getOneBy(["actionID"=>7]);
        $currentUser = UserManager::getOneBy(["userID"=>$user->getId()]); 

        $userAction = new UserAction ($action, $currentUser,new DateTime(),new DateTime());

        $exec = UserActionManager::insert($userAction,$ticketID);

        if($exec) {
            header("location:?p=ticket&action=show&id=" . $ticketID);
            exit();
        } else {
            throw new ManagerException ("Impossible de mettre à jour la BDD");
        }
    }
}