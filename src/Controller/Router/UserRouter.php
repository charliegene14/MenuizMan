<?php

namespace App\Controller\Router;

use App\Services\Authentication;
use App\Exception\NotFoundException;
use App\Controller\Profil\ProfilController;
use App\Controller\Search\SearchController;
use App\Controller\Ticket\TicketController;
use App\Controller\Article\ArticleController;
use App\Controller\Customer\CustomerController;
use App\Controller\Purchase\PurchaseController;
use App\Controller\Ticket\TicketListController;
use App\Controller\Stats\StatsController;

class UserRouter {
    
    /**
     * Main router for users
     *
     * @return void
     */
    public static function main() {
        
        global $page;
        global $user;

        switch ($page) {

            case "home":
                TicketListController::home();
                break;

            case "search":
                SearchController::main();
                break;

            case "ticket":
                TicketController::main();
                break;

            case "purchase":
                PurchaseController::main();
                break;

            case "customer":
                CustomerController::main();
                break;
                
            case "tickets":
                TicketListController::main(); 
                break;

            case "article":
                ArticleController::main();
                break;

            case "logout":
                Authentication::logout();
                break;

            case "profil":
                ProfilController::main();
                break;

            case "stats":
                if ($user->getRole()->getId() !== "MNG") throw new NotFoundException();
                
                StatsController::main();
                break;

            default:
                throw new NotFoundException();
        }
    }
}