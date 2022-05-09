<?php

namespace App\Services;

use App\Manager\UserManager;
use App\Entity\User;

class Authentication
{

    /**
     * Check login and password from database
     *
     * @param string $login
     * @param string $password
     * @return boolean
     */
    public static function isValidCredentials(string $login, string $password): bool {

        $user = UserManager::getBy([
            "login" => $login
        ]);

        if (!$user) return false;

        $isValid = password_verify($password, $user[0]->getPassword());
        
        if ($isValid) self::initSession($user[0]);
        
        return $isValid;

    }

    /**
     *  Initialize the user session
     *
     * @param User $user
     * @return void
     */
    private static function initSession(User $user) {
    
        $token = bin2hex(random_bytes(32));
        
        $_SESSION["connected"] = true;
        
        $userAuth = new UserAuth(
            $user->getId(),
            $token,
            $user->getFirstName(),
            $user->getLastName(),
            $user->getRole()
        );

        $_SESSION["userAuth"] = serialize($userAuth);
    }

    /**
     * Get the user session
     *
     * @return UserAuth|null
     */
    public static function getUser(): ?UserAuth {

        if (!isset($_SESSION["connected"]) && !isset($_SESSION["userAuth"]) || !$_SESSION["connected"]) return null;
        return unserialize($_SESSION["userAuth"]);
    }

    /**
     * Logout the user session
     *
     * @return void
     */
    public static function logout() {
        header("location: ./");
        session_unset();
        session_destroy();
        exit();
    }
}