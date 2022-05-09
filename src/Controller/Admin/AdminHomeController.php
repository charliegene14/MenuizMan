<?php

namespace App\Controller\Admin;

use App\Manager\UserManager;

class AdminHomeController {

    /**
     * Main controller of admin's home page
     *
     * @return void
     */
    public static function main() {
       
        global $user;
        
        $users = UserManager::getAll(["userID" => "ASC"]);

        include "views/admin/home.php";
    }
}