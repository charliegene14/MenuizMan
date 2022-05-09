<?php

namespace App\Controller\Search;

use App\Exception\NotFoundException;

class SearchController {
    
    /**
     * Main search controller
     *
     * @return void
     */
    public static function main() {

        global $user;

        $hasSearch = false;

        if (isset($_POST["searched"])) {
            $hasSearch = true;
           
            $action = htmlentities($_POST["searched"]);

            switch($action) {

                case "ticket":
                    $displayTable = SearchTicketController::search($_POST);
                    break;
                case "customer":
                    $displayTable = SearchCustomerController::search($_POST);
                    break;
                
                case "purchase":
                    $displayTable = SearchPurchaseController::search($_POST);
                    break;

                case "article":
                    $displayTable = SearchArticleController::search($_POST);
                    break;

                case "quick":
                    echo json_encode(SearchTicketController::quickSearch($_POST["id"]));
                    exit();

                    break;

                default:
                    throw new NotFoundException();
            }
        }

        include "views/search.php";
    }
}
