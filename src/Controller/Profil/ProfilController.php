<?php

namespace App\Controller\Profil;

use App\Exception\NotFoundException;
use App\Manager\TicketManager;
use App\Manager\UserManager;

class ProfilController {

    /**
     * Main controller for profil page. Actions:
     * + update_password
     *
     * @return void
     */
    public static function main() {

        global $user;
        
        $hasError = false;
        $hasChanged = false;

        $action = isset($_GET["action"]) ? htmlentities($_GET["action"]) : null;

        $objUser = UserManager::getOneBy(["userID" => $user->getId()]);

        if ($user->getRole()->getId() !== "ADM") {
            $tickets = TicketManager::getInWorkTicketsOf($objUser);
        }
        
        switch ($action) {
            case "update_password":

                if (empty($_POST)) throw new NotFoundException();

                $msgError = "";

                if ($_POST["newPassword1"] !== $_POST["newPassword2"]) {
                    $msgError = "Les mots de passe de correspondent pas !";
                    $hasError = true;
                    
                } elseif (!password_verify($_POST["oldPassword"], $objUser->getPassword())) {
                    $msgError = "Mot de passe incorrect !";
                    $hasError = true;

                } elseif ($_POST["newPassword1"] === "" || empty($_POST["newPassword1"]) || !isset($_POST["newPassword1"])) {
                    $msgError = "Tu bluff martoni !";
                    $hasError = true;

                } else {
                    
                    $hash = password_hash($_POST["newPassword2"], PASSWORD_DEFAULT);
                    $objUser->updatePassword($hash);

                    $update = UserManager::update($objUser);

                    if ($update) {
                        $hasChanged = true;
                        session_unset();
                    } else {
                        $msgError = "Une erreur est survenue, réessayez.";
                        $hasError = true;
                    }
                }
                
            break;
        }

        require "views/profil.php";
    }


}