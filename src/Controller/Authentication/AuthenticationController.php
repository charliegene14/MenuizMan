<?php

namespace App\Controller\Authentication;

use App\Services\Authentication;

class AuthenticationController {

    /**
     * Main controller for the login page.
     * Actions:
     * + credentials_validation - for ajax credentials validation
     *
     * @return void
     */
    public static function main() {

        global $user;
        
        $action = isset($_POST["action"]) ? $_POST["action"] : null;

        switch ($action) {

            case "credentials_validation":
                
                $isOK = Authentication::isValidCredentials(
                    $_POST["login"],
                    $_POST["password"]
                );
                
                echo $isOK;

                exit();
                break;
        }

        require "views/login.php";
    }
}