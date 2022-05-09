<?php

namespace App\Manager;

use App\Entity\User;
use App\Entity\Ticket;
use App\Manager\UserActionManager;
use App\Exception\ManagerException;

class TicketManager extends AbstractManager
{
    public const TABLE = "ticket";

    /**
     * Map each database row as object entity
     *
     * @param integer $ticketID
     * @param string $ticketTypeID
     * @param integer $purchaseID
     * @param integer $isClosed
     * @param integer $isUrgent
     * @param string $articleID
     * @param integer $treatedQty
     * @param string $commentary
     * @return Ticket
     */
    public static function rowMapper(
        int $ticketID,
        string $ticketTypeID,
        int $purchaseID,
        int $isClosed,
        int $isUrgent,
        ?string $articleID,
        ?int $treatedQty,
        ?string $commentary
    ): Ticket
    {

        $ticket = new Ticket(
            TicketTypeManager::getOneBy(["ticketTypeID" => $ticketTypeID]),
            PurchaseManager::getOneBy(["purchaseID" => $purchaseID]),
            $isClosed?true:false,
            $isUrgent?true:false,
            ArticleManager::getOneBy(["articleID" => $articleID]),
            $treatedQty,
            $commentary,
            $ticketID
        );

        //actions sur ticket
        $actions = UserActionManager::getBy(
            [
                "ticketID" => $ticketID
            ],
            [
                "doID" => "ASC"
            ]
        );


        $ticket->setActions($actions);

        return $ticket;
    }

    /**
     * Update a Database Ticket from a php entity Ticket
     * 
     * @param Ticket $ticket
     * @return Ticket|null
     */
    public static function update(Ticket $ticket) : ?Ticket {

        $str = "UPDATE ". self::TABLE . " SET ";
        $str .= "ticketTypeID=:tycketTypeID, ";
        $str .= "purchaseID=:purchaseID,";
        $str .= "closed=:closed,";
        $str .= "urgent=:urgent,";
        $str .= "articleID=:articleID,";
        $str .= "treatedQty=:treatedQty,";
        $str .= "commentary=:commentary ";
        $str .= "WHERE ticketID = :ticketID;";

        $query = self::db()->prepare($str);

        $query->bindValue("tycketTypeID",$ticket->getType()->getId());
        $query->bindValue("purchaseID",$ticket->getPurchase()->getId());
        $query->bindValue("closed",$ticket->isClosed()?1:0);
        $query->bindValue("urgent",$ticket->isUrgent()?1:0);
        $query->bindValue("articleID", $ticket->getArticle() ? $ticket->getArticle()->getId() : null);
        $query->bindValue("treatedQty",$ticket->getTreatedQty() ? $ticket->getTreatedQty() : null);
        $query->bindValue("commentary", $ticket->getCommentary() ? $ticket->getCommentary() : null);
        $query->bindValue("ticketID",$ticket->getId());

        $exec = $query->execute();

        if($exec) {
            self::updateUserAction($ticket);
            self::disconnect();
            return $ticket;
        }

        self::disconnect();
        return null;
    }

    /**
     * Update a Database doonTicket from a php entity Ticket
     *
     * @param Ticket $ticket
     * @return void
     */
    private static function updateUserAction(Ticket $ticket){
        $tUserAction = $ticket->getActions();
        foreach($tUserAction as $userAction){
            $userActionInDb = UserActionManager::getOneBy([
                "doID"=>$userAction->getId()
            ]);
            if($userActionInDb){
                UserActionManager::update($userAction);
            } else {
                UserActionManager::insert($userAction, $ticket->getId());
            }
        }
    }

    /**
     * Insert a Database Ticket from a php entity Ticket
     *
     * @param Ticket $ticket
     * @return Ticket|null
     */
    public static function insert(Ticket $ticket) : ?Ticket {

        $str = "INSERT INTO " . self::TABLE . " (ticketTypeID, purchaseID, closed, urgent, articleID, treatedQty, commentary) 
            VALUES (:ticketTypeID, :purchaseID, :closed, :urgent, :articleID, :treatedQty, :commentary);";

        $query = self::db()->prepare($str);

        $query->bindValue("ticketTypeID",$ticket->getType()->getId());
        $query->bindValue("purchaseID",$ticket->getPurchase()->getId());
        $query->bindValue("closed",$ticket->isClosed()?1:0);
        $query->bindValue("urgent",$ticket->isUrgent()?1:0);        
        $query->bindValue("articleID", $ticket->getArticle() ? $ticket->getArticle()->getId() : NULL);
        $query->bindValue("treatedQty", $ticket->getTreatedQty() ? $ticket->getTreatedQty() : 0);
        $query->bindValue("commentary",$ticket->getCommentary());

        $exec = $query->execute();

        if($exec) {

            $id = self::db()->query("SELECT LAST_INSERT_ID() as id FROM ticket")->fetch()["id"];

            $tUserAction = $ticket->getActions();

            foreach($tUserAction as $action) {

                UserActionManager::insert($action, $id);
            }

            self::disconnect();
            return self::getOneBy(["ticketID" => intval($id)]);

        }

        self::disconnect();
        return null;
    }

    /**
     * Get all tickets to database that need a Diagnostic action
     *
     * @return array<Ticket>
     */
    public static function getToDiagnostic(): array {

        $sav = self::getBy([
            "ticketTypeID" => "SAV"
        ]);

        $todiag = [];

        /**
         * @var Ticket
         */
        foreach ($sav as $ticket) {

            if (
                $ticket->getLastAction()->getAction()->getId() === 2
                ||  (
                        $ticket->getLastAction()->getAction()->getId() === 3
                        && !$ticket->getLastAction()->getStart()
                    )
            )
            {
                $todiag[] = $ticket;
            }
        }

        return $todiag;
    }

    /**
     * Get all tickets to database that need a reship action
     *
     * @return array
     */
    public static function getToShip(): array {

        $tickets = self::getBy([
            "ticketTypeID" => [
                "SAV",
                "NPAI",
                "EP",
                "NP",
            ]
        ]);

        $toship = [];

        /**
         * @var Ticket
         */
        foreach ($tickets as $ticket) {

            if (
                $ticket->getLastAction()->getAction()->getId() === 6
                && !$ticket->getLastAction()->getStart()
            )
            {
                $toship[] = $ticket;
            }
        }

        return $toship;
    }
    
    /**
     * Select Tickets in database with conditions LIKE from an attributes array
     *
     * @param array $attributes
     * @param array|null $orderBy
     * @return array<Ticket>
     */
    public static function searchBy(array $attributes, ?array $orderBy = null): array {

        if ($attributes === []) throw new ManagerException("Impossible d'effectuer une recherche sans filtres");

        $str = "SELECT * FROM " . get_called_class()::TABLE;
        $str .= " t JOIN purchase p ON p.purchaseID = t.purchaseID JOIN customer c ON c.customerID=p.customerID"; 
        
        $str .= " WHERE 1 = 1";

        foreach ($attributes as $attribute => $value) {
            $str .= " AND UPPER(" . $attribute . ") LIKE CONCAT('%',UPPER(:" . $attribute . "),'%')" ;
        }

        // Complete the query string if ODER BY clause is set
        //if ($orderBy) $str = self::addOrderClause($str, $orderBy);

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
     * Select Tickets in databse with a starting date Condition
     *
     * @param array $attributes
     * @return array
     */
    public static function searchWithDate(array $attributes): array {
        if ($attributes === []) throw new ManagerException("Impossible d'effectuer une recherche sans filtres");

        $str = "SELECT t.ticketID,t.ticketTypeID,t.purchaseID,t.closed,t.urgent,t.articleID,t.treatedQty,t.commentary FROM ticket t JOIN purchase p ON p.purchaseID = t.purchaseID 
        JOIN customer c ON c.customerID = p.customerID JOIN address a ON a.addressID = c.addressID JOIN city ON city.COG = a.COG AND city.postCode = a.postCode JOIN
        doonticket d ON d.ticketID = t.ticketID WHERE 1 = 1";

        
       $str .= " WHERE 1=1";

        foreach ($attributes as $attribute => $value) {
            if($attribute === "custFirstName" || $attribute === "custLastName"){
                $str .= " AND UPPER(c." . $attribute . ") LIKE CONCAT('%',UPPER(:" . $attribute . "),'%')" ;
            } else if($attribute === "startingTime"){
                $str .= " AND UPPER(d." . $attribute . ") LIKE CONCAT('%',UPPER(:" . $attribute . "),'%')" ;
            } else {
                $str .= " AND UPPER(t." . $attribute . ") LIKE CONCAT('%',UPPER(:" . $attribute . "),'%')" ;
            }
        }

        $str .= " GROUP BY ticketID";
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
     * Get all tickets a user is working on
     *
     * @param User $user
     * @return array
     */
    public static function getInWorkTicketsOf(User $user): array {
        
        $str = "SELECT DISTINCT(t.ticketID) FROM ticket t LEFT JOIN doonticket d ON d.ticketID = t.ticketID";
        $str .= " WHERE d.userID = :userID AND d.startingTime IS NOT NULL AND d.endingTime IS NULL";

        $query = self::db()->prepare($str);

        $query->bindValue("userID", $user->getId());
        $exec = $query->execute();

        $aTickets = [];

        if ($exec) {
            $ids = $query->fetchAll();

            foreach ($ids as $id) {
                $aTickets[] = self::getOneBy(["ticketID" => $id]);
            }

            return $aTickets;
        }
        return [];
    }

    /**
     * Get count of finished tickets of a single type
     *
     * @param string $idType
     * @return integer|null
     */
    public static function getDoneCountOf(string $idType): ?int {

        $str = "SELECT COUNT(ticketID) as nb FROM ticket WHERE ticketTypeID = :idType AND closed = 1";

        $query = self::db()->prepare($str);
        $query->bindValue("idType", $idType);

        $exec = $query->execute();

        if ($exec) {
            return $query->fetch()['nb'];
        }

        return null;
    }

    /**
     * Get count of all finished tickets
     *
     * @return integer|null
     */
    public static function getDoneCount(): ?int {
        $str = "SELECT COUNT(ticketID) as nb FROM ticket WHERE  closed = 1";

        $query = self::db()->prepare($str);
        $exec = $query->execute();

        if ($exec) {
            return $query->fetch()['nb'];
        }

        return null;
    }

    /**
     * Get count of unclosed tickets filtered by Type and incoming Action
     *
     * @param string $idType
     * @param integer $nextAction
     * @return integer|null
     */
    public static function getInWorkCount(string $idType, int $nextAction): ?int {

        $str = "SELECT COUNT(t.ticketID) as nb FROM ticket t ";
        $str .= "LEFT JOIN doonticket d ON d.ticketID = t.ticketID ";
        $str .= "WHERE t.closed = 0 ";
        $str .= "AND t.ticketTypeID = :idType ";
        $str .= "AND d.actionID = :nextAction ";
        $str .= "AND d.startingTime IS NULL ";
        $str .= "AND d.endingTime IS NULL";

        $query = self::db()->prepare($str);

        $query->bindValue("idType", $idType);
        $query->bindValue("nextAction", $nextAction);

        $exec = $query->execute();

        if ($exec) {
            return $query->fetch()['nb'];
        }

        return null;

    }
}