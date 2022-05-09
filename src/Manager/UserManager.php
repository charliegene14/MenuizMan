<?php

namespace App\Manager;

use App\Entity\Role;
use App\Entity\User;
use App\Exception\ManagerException;

class UserManager extends AbstractManager {

    public const TABLE = "_user";

    public const JOINS = [
        "role" => "_user.roleID = role.roleID"
    ];

    /**
     * Map each database row as object entity
     *
     * @param integer $id
     * @param string $firstName
     * @param string $lastName
     * @param string $login
     * @param string $password
     * @param string $roleID
     * @param string $roleName
     * @return User
     */
    public static function rowMapper(
        int $id,
        string $firstName,
        string $lastName,
        string $login,
        string $password,
        string $roleID,
        string $roleName

    ): User {

        $role = new Role($roleID, $roleName);

        return new User(
            $firstName,
            $lastName,
            $role,
            $login,
            $password,
            $id
        );
    }

    /**
     *
     * @param array $attributes
     * @return User|null
     */
    public static function getOneBy(array $attributes): ?object {
        return parent::getOneBy($attributes);
    }

    /**
     * Insert a Database User from a php entity User
     *
     * @param User $user
     * @return void
     */
    public static function insert(User $user): ?User {
        
        $str = "INSERT INTO " . self::TABLE . " (firstName, lastName, roleID, login, password) ";
        $str .= "VALUES (:firstName, :lastName, :roleId, :login, :password)";
        $query = self::db()->prepare($str);

        $query->bindValue("firstName", $user->getFirstName());
        $query->bindValue("lastName", $user->getLastName());
        $query->bindValue("roleId", $user->getRole()->getId());
        $query->bindValue("login", $user->getLogin());
        $query->bindValue("password", $user->getPassword());

        $exec = $query->execute();
        
        if ($exec) {

            $id = self::db()->query("SELECT MAX(userID) as id FROM " . self::TABLE)->fetch()["id"];
            self::disconnect();
            return self::getOneBy([
                "userID" => $id
            ]);

        }

        self::disconnect();
        return null;
    }

    /**
     * Update a Database User from a php entity User
     *
     * @param User $user
     * @return User|null
     */
    public static function update(User $user): ?User {

        if (!$user->getId()) throw new ManagerException("User must have ID.");

        $str = "UPDATE " . self::TABLE . " SET ";
        $str .= "firstName = :firstName, lastName = :lastName, login = :login, password = :password, roleID = :roleID";
        $str .= " WHERE userID = :id";

        $query = self::db()->prepare($str);

        $query->bindValue("id", $user->getId());
        $query->bindValue("firstName", $user->getFirstName());
        $query->bindValue("lastName", $user->getLastName());
        $query->bindValue("roleID", $user->getRole()->getId());
        $query->bindValue("login", $user->getLogin());
        $query->bindValue("password", $user->getPassword());

        $exec = $query->execute();

        if ($exec) {
            self::disconnect();
            return $user;
        }

        self::disconnect();
        return null;
    }

}