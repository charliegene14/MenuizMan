<?php

namespace App\Controller\Purchase;

use App\Exception\NotFoundException;
use App\Manager\PurchaseManager;

class PurchaseController {

    /**
     * Main controller for single purchase page. Actions:
     * + show
     *
     * @return void
     */
    public static function main() {

        global $user;

        $action = isset($_GET["action"]) ? $_GET["action"] : null;

        switch ($action) {

            case "show":

                if (!isset($_GET["id"]) || empty($_GET["id"])) throw new NotFoundException();
                $id = $_GET["id"];

                $purchase = PurchaseManager::getOneBy(["purchaseID" => $id]);
                if (!$purchase) throw new NotFoundException();

                include "views/purchase.php";
                break;

            default:
                throw new NotFoundException();
        }
    }
}