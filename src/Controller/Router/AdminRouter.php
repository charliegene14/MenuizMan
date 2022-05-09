<?php

namespace App\Controller\Router;

use App\Services\Authentication;
use App\Exception\NotFoundException;
use App\Controller\User\UserController;
use App\Controller\Profil\ProfilController;
use App\Controller\Admin\AdminHomeController;

class AdminRouter {

    /**
     * Main router for Admin users
     *
     * @return void
     */
    public static function main() {

        global $page;
        
        switch ($page) {

            case "home":
                AdminHomeController::main();
                break;

            case "user":
                UserController::main();
                break;

            case "profil":
                ProfilController::main();
                break;

            case "logout":
                Authentication::logout();
                break;

            default:
                throw new NotFoundException();
        }

    }
}