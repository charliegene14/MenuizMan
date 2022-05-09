<?php

namespace App\Services;
use PDO;

class Database {

    private static $connexion;

    public const USER_DEFAULT = "USER_DEFAULT";
    public const DB_FILE      = "settings/database.ini";

    /**
     * Dabatabse connection
     *
     * @param string $user
     * @return PDO
     */
    private static function connect(string $user = self::USER_DEFAULT): PDO {

        $db         = parse_ini_file(self::DB_FILE, true)["DB"];
        $user_data  = parse_ini_file(self::DB_FILE, true)[strtoupper($user)];

        self::$connexion = new PDO(
            "mysql:host=" .$db["HOST"]. "; port=".$db["PORT"]."; dbname=".$db["DBNAME"]."; charset=utf8",
            $user_data["USER"],
            $user_data["PASSWORD"],array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
        );

        return self::$connexion;
    }

    /**
     * Database disconnection
     * 
     * @return void
     */
    public static function disconnect(): void {
        self::$connexion = null;
    }

    /**
     * Get the databse connexion
     * 
     * @return PDO
     */
    public static function getConnexion(?string $user = self::USER_DEFAULT): PDO {
        if (self::$connexion != null) {
            return self::$connexion;
        } else {
            return self::connect($user);
        }
    }
}