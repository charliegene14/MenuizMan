<?php

namespace App\Manager;

use PDO;
use App\Services\Database;
use App\Exception\ManagerException;
use PDOStatement;

abstract class AbstractManager {

    public const JOINS = NULL;

    /**
     * Connect to database
     *
     * @return PDO
     */
    protected static function db(): PDO {

        global $user;
       
        $dbUser = isset($user) ? "USER_" . $user->getRole()->getId() : Database::USER_DEFAULT;

        return Database::getConnexion($dbUser);
    }

    /**
     * Disconnect from database
     *
     * @return void
     */
    protected static function disconnect(): void {
        Database::disconnect();
    }

    /**
     * Get all rows in table
     *
     * @return array<object>
     */
    public static function getAll(?array $orderBy = null): array {
        
        $str = "SELECT * FROM ". get_called_class()::TABLE;

        // // Whether child class has joins
        if (get_called_class()::JOINS) {

            $str = self::addJoinClause(
                $str,
                get_called_class()::JOINS
            );
        }
        //dd($str);
        // Complete the query string if ODER BY clause is set
        if ($orderBy) $str = self::addOrderClause($str, $orderBy);

        //dd($str);
        $query = self::db()->prepare($str);
        $query->execute();

        return self::mapper($query);
    }

   
    /**
     * Get rows according to fields values
     *
     * @param array $attributes
     * @return array<object>
     */
    public static function getBy(array $attributes, ?array $orderBy = null): array {

        if ($attributes === []) throw new ManagerException("getWhere() must take at least one value");

        $str = "SELECT * FROM " . get_called_class()::TABLE;
        
        // Whether child class has joins
        if (get_called_class()::JOINS) {

            $str = self::addJoinClause(
                $str,
                get_called_class()::JOINS
            );
        }
        
        $str .= " WHERE 1 = 1";

        foreach ($attributes as $attribute => $value) {

            $str .= " AND ( ";

            if (is_array($value)) {

                $i = 1;

                foreach ($value as $sub) {
                    $str .= $attribute . " = :" . str_replace(".", "_", $attribute) . $i . " ";

                    if ($i != count($value))
                        $str .= "OR ";
                    else
                        $str .= ")";
                    $i++;
                }

            } else {
                $str .= $attribute . " = :" . str_replace(".", "_", $attribute) . " )" ;
            }
            
        }
        
        // Complete the query string if ODER BY clause is set
        if ($orderBy) $str = self::addOrderClause($str, $orderBy);

        $query = self::db()->prepare($str);

        foreach($attributes as $attribute => $value) {
            
            if (is_array($value)) {

                $i = 1;

                foreach ($value as $sub) {
                    $query->bindValue(str_replace(".", "_", $attribute) . $i, $sub);
                    $i++;
                }

            } else {
                $query->bindValue(
                    str_replace(".", "_", $attribute),
                    $value
                );
            }
        }

        $query->execute();
        return self::mapper($query);
    }


    /**
     * Select in database with conditions LIKE from an attributes array
     *
     * @param array $attributes
     * @param array|null $orderBy
     * @return array
     */
    public static function searchBy(array $attributes, ?array $orderBy = null): array {

        if ($attributes === []) throw new ManagerException("getWhere() must take at least one value");
        
        $str = "SELECT * FROM " . get_called_class()::TABLE;
       
        // Whether child class has joins
        if (get_called_class()::JOINS) {

            $str = self::addJoinClause(
                $str,
                get_called_class()::JOINS
            );
        }
        
        $str .= " WHERE 1 = 1";

        foreach ($attributes as $attribute => $value) {
            $str .= " AND " . $attribute . " LIKE CONCAT('%', :" . $attribute . ", '%')" ;
        }

        // Complete the query string if ODER BY clause is set
        if ($orderBy) $str = self::addOrderClause($str, $orderBy);

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
     * Get one row returned as object
     *
     * @param array $attributes
     * @return object|null
     */
    public static function getOneBy(array $attributes): ?object {
        
        $return = self::getBy($attributes);

        if ($return)
            return $return[0];
        return null;
    }

    /**
     * Delete row according to fields values
     *
     * @param array $attributes
     * @return boolean
     */
    public static function deleteBy(array $attributes): bool {

        if ($attributes === [] || count($attributes) === 0) throw new ManagerException("deleteBy() must take at least one value");

        $str = "DELETE FROM " . get_called_class()::TABLE .  " WHERE 1 = 1";

        foreach ($attributes as $attribute => $value) {
            $str .= " AND " . $attribute . " = :" . $attribute ;
        }

        $query = self::db()->prepare($str);

        foreach($attributes as $attribute => $value) {

            $query->bindValue(
                $attribute,
                $value    
            );
        }

        $exec = $query->execute();
        self::disconnect();

        if ($exec) return true;
        return false;
    }

    /**
     * Add order clause to query string
     *
     * @param string $queryString
     * @param array $orderBy
     * @return string
     */
    protected static function addOrderClause(string $queryString, array $orderBy): string {

        $queryString .= " ORDER BY ";
        $i = 0;

        foreach($orderBy as $attribute => $order) {
            $i++;
            $queryString .= "$attribute $order";

            if (count($orderBy) > 1 && $i !== count($orderBy))
                $queryString .= ", ";
        }

        return $queryString;
    }

    /**
     *  Add joins clauses to query string
     *
     * @param string $queryString
     * @param array $joins
     * @return string
     */
    protected static function addJoinClause(string $queryString, array $joins): string {
        
        foreach ($joins as $table => $join) {

            $queryString .= " LEFT JOIN $table ON ";

            if(!is_array($join)) {
                $queryString .= $join;

            } elseif (is_array($join)) {
                $i = 0;
                foreach ($join as $key) {
                    $i++;
                    $queryString .= $key;

                    if ($i !== count($join)) {
                        $queryString .= " AND ";
                    }
                }
            }
            
        }

        return $queryString;
    }

    /**
     * Transform selected datas from DB to their matching app entities
     *
     * @param PDOStatement|null $query
     * @return array|null
     */
    protected static function mapper(?PDOStatement $query): ?array {

        $result = $query->fetchAll(
            PDO::FETCH_FUNC,
            get_called_class() . "::rowMapper"
        );

        self::disconnect();
        return $result;
    }
}