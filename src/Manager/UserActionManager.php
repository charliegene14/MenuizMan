<?php

namespace App\Manager;

use DateTime;
use App\Entity\Role;
use App\Entity\User;
use App\Entity\Action;
use App\Entity\Ticket;
use App\Entity\UserAction;
use App\Exception\ManagerException;

class UserActionManager extends AbstractManager
{
    public const TABLE = "doonticket";

    public const JOINS = [
        "_user" => "doonticket.userID = _user.userID",
        "role" => "_user.roleID = role.roleID",
        "action" => "doonticket.actionID = action.actionID"
    ];

    /**
     * Map each database row as object entity
     *
     * @param integer $id
     * @param integer|null $userID
     * @param integer $ticketID
     * @param integer $actionID
     * @param string|null $startingTime
     * @param string|null $endingTime
     * @param string|null $commentary
     * @param integer|null $user_userID
     * @param string|null $user_firstName
     * @param string|null $user_lastName
     * @param string|null $user_login
     * @param string|null $user_password
     * @param string|null $user_roleID
     * @param string|null $roleID
     * @param string|null $roleName
     * @param integer $action_actionID
     * @param string $actionType
     * @return UserAction
     */
    public static function rowMapper(
        int $id,
        ?int $userID = NULL,
        int $ticketID,
        int $actionID,
        ?string $startingTime = NULL,
        ?string $endingTime = NULL,
        ?string $commentary = NULL,
        ?int $user_userID,
        ?string $user_firstName= NULL,
        ?string $user_lastName = NULL,
        ?string $user_login = NULL,
        ?string $user_password = NULL,
        ?string $user_roleID = NULL,
        ?string $roleID = NULL,
        ?string $roleName = NULL,
        int $action_actionID,
        string $actionType

    ) : UserAction
    {
        $startingTime = $startingTime ? new DateTime($startingTime) : null;
        $endingTime = $endingTime ? new DateTime($endingTime) : null;

        if ($userID) {

            $role = new Role(
                $roleID,
                $roleName
            );
    
            $user = new User(
                $user_firstName,
                $user_lastName,
                $role,
                $user_login,
                $user_password,
                $userID
            );
        } else {

            $role = NULL;
            $user = NULL;
        }

        $action = new Action(
            $action_actionID,
            $actionType
        );

        $userAction = new UserAction(
            $action,
            $user,
            $startingTime,
            $endingTime,
            $commentary,
            $id
        );


        return $userAction;
    }
    
    /**
     * Insert a Database doonTicket from a php entity UserAction
     *
     * @param UserAction $userAction
     * @param Ticket $ticket
     * @return UserAction|null
     */
    public static function insert (UserAction $userAction, int $ticketID) : ?UserAction {

        $str = "INSERT INTO " . self::TABLE;
        $str .= " (userID, ticketID, actionID, startingTime, endingTime, commentary) ";
        $str .= "VALUES (:userID, :ticketID, :actionID, :startingTime, :endingTime, :commentary);";

        $query = self::db()->prepare($str);

        $query ->bindValue("userID", $userAction->getUser() ? $userAction->getUser()->getId() : NULL);
        $query ->bindValue("ticketID", $ticketID);
        $query ->bindValue("actionID", $userAction->getAction()->getId());

        $datetimeStart = $userAction->getStart() ? $userAction->getStart()->format("Y-m-d H:i:s") : null;
        $datetimeEnd = $userAction->getEnd() ? $userAction->getEnd()->format("Y-m-d H:i:s") : null;

        $query ->bindValue("startingTime", $datetimeStart);
        $query ->bindValue("endingTime", $datetimeEnd);
        $query ->bindValue("commentary", $userAction->getCommentary());

        $exec = $query->execute();
        self::disconnect();

        if ($exec) {

            if($userAction->getAction()->getId() === 7) {
                self::deleteOndoingTasks($ticketID);
            }
            return $userAction;
        }

        return null;
    }


    /**
     * Call a procedure that delete all unfinished tasks from doonticket filtered by TicketID
     *
     * @param integer $ticketID
     * @return void
     */
    private static function deleteOndoingTasks(int $ticketID) {
        $str ="CALL prc_del_todo_task(:ticketID)";

        $query = self::db()->prepare($str);
        $query ->bindValue("ticketID",$ticketID);
        $exec = $query->execute();
        self::disconnect();
    }
    /**
     * Update a Database doonTicket from a php entity UserAction
     *
     * @param UserAction $userAction
     * @param Ticket $ticket
     * @return UserAction|null
     */
    public static function update (UserAction $userAction) : ?UserAction {

        if (!$userAction->getId()) throw new ManagerException("User action must have an ID.");

        $str = "UPDATE " . self::TABLE;
        $str .= " SET userID = :userID, actionID = :actionID,";
        $str .= " startingTime = :startingTime , endingTime = :endingTime , commentary = :commentary";
        $str .= " WHERE doID = :doID";

        $query = self::db()->prepare($str);

        $query ->bindValue("doID", $userAction->getId());
        $query ->bindValue("userID", $userAction->getUser()?$userAction->getUser()->getId():null);
        $query ->bindValue("actionID",$userAction->getAction()->getId());

        $datetimeStart = $userAction->getStart() ? $userAction->getStart()->format("Y-m-d H:i:s") : null;
        $datetimeEnd = $userAction->getEnd() ? $userAction->getEnd()->format("Y-m-d H:i:s") : null;

        $query ->bindValue("startingTime", $datetimeStart);
        $query ->bindValue("endingTime", $datetimeEnd);

        $query ->bindValue("commentary",$userAction->getCommentary());

        $exec = $query->execute();
        self::disconnect();

        if ($exec) 
            return $userAction;
        return null;
    }

    /**
     *
     * @param array $attributes
     * @return UserAction|null
     */
    public static function getOneBy(array $attributes): ?object {
        return parent::getOneBy($attributes);
    }

    /**
     * Call a procedure that delete all unfinished tasks from doonticket filtered by TicketID
     *
     * @param integer $ticketid
     * @return void
     */
    public static function changeTask(int $ticketid) {
        $str = "CALL  prc_del_todo_task(:ticketID)";
        $query = self::db()->prepare($str);
        $query->bindValue("ticketID",$ticketid);
        $exec = $query->execute();
        self:: disconnect();
        return $exec;
    }
}