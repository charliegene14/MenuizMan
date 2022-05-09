<?php

namespace App\Controller\Ticket;

use DateTime;
use Exception;
use App\Entity\City;
use App\Entity\Ticket;
use App\Entity\Address;
use App\Entity\Customer;
use App\Entity\UserAction;
use App\Manager\CityManager;
use App\Manager\UserManager;
use App\Manager\ActionManager;
use App\Manager\TicketManager;
use App\Manager\AddressManager;
use App\Manager\ArticleManager;
use App\Manager\CustomerManager;
use App\Manager\PurchaseManager;
use App\Manager\TicketTypeManager;

class TicketCreateController {


    /**
     * Controller for ticket creation. Actions:
     * + ajax_purchase_validation
     * + ajax_get_purchases
     * + ajax_add_ticket_form
     * + ajax_submit_ticket
     *
     * @return void
     */
    public static function create() {

        global $user;

        $action         = isset($_POST["action"]) ? htmlentities($_POST["action"]) : false;

        $purchaseID     = isset($_GET["purchase_id"]) ? htmlentities($_GET["purchase_id"]) : false;
        $ticketType     = isset($_GET["ticket_type"]) ? htmlentities($_GET["ticket_type"]) : false;

        $ticketNumber = 1;

        if ($purchaseID)
            $purchase = PurchaseManager::getOneBy(["purchaseID" => $purchaseID]);

        if (isset($purchase) && !empty($purchase))
            $typeList = TicketTypeManager::getAll();

        if (isset($ticketType) && !empty($ticketType))
            $type = TicketTypeManager::getOneBy(["ticketTypeID" => $ticketType]);

        if ($action === "ajax_purchase_validation") {

            if ($purchase) echo json_encode(true);
            else echo json_encode(false);
            exit();

        } else if ($action === "ajax_get_purchases") {

            $value  = isset($_POST["value"]) ? intval($_POST["value"]) : "";
            $aID     = [];

            $purchases = PurchaseManager::searchBy(["purchaseID" => $value]);

            foreach ($purchases as $purchase) {
                $aID[] = $purchase->getId();
            }

            echo json_encode($aID);
            exit();

        } else if ($action === "ajax_add_ticket_form") {

            $ticketNumber =  htmlentities($_POST["ticketNumber"]);
            include "views/templates/create_tickets_forms/ticket_form.php";
            exit();

        } else if ($action === "ajax_submit_ticket") {

            if (!$purchase && !$type) throw new Exception("No type or no purchase.");
     
            $tickets = $_POST["datas"]["tickets"];
            $areOK = [];
            $i = 0;

            foreach($tickets as $ticket) {
                $i++;
                $article    = isset($ticket["article"]) && $ticket["article"]["id"] !== NULL ? ArticleManager::getOneBy(["articleID" => $ticket["article"]["id"]]) : NULL;

                if ($article) {
                    if (empty($ticket["article"]["quantity"]) || !$ticket["article"]["quantity"]) {
                        $qty = 1;
                    } else {
                        $qty = intval($ticket["article"]["quantity"]);
                    }
                } else {
                    $qty = null;
                }

                $commentary = htmlentities($ticket["commentary"]);

                $obj_ticket = new Ticket(
                    $type,
                    $purchase,
                    false,
                    false,
                    $article,
                    $qty,
                    $commentary
                );

                // Action créer
                $obj_ticket->addAction(
                    new UserAction(
                        ActionManager::getOneBy(["actionID" => 1]),
                        UserManager::getOneBy(["userID" => $user->getId()]),
                        new DateTime(),
                        new DateTime(),
                        "Commande n°".$purchase->getId() 
                    )
                );

                //Action récéption
                $obj_ticket->addAction(
                    new UserAction(
                        ActionManager::getOneBy(["actionID" => 2]),
                        null,
                        null,
                        null,
                        $article ? "Réf. article n°".$article->getId() . " (x ". $qty .")" : "Toute la commande"
                    )
                );

                if ($type->getId() === "SAV") {
                    $obj_ticket->addAction(
                        new UserAction(
                            ActionManager::getOneBy(["actionID" => 3]),
                            null,
                            null,
                            null,
                            "Garantie ?"
                        )
                    );

                }
                else if ($type->getId() === "NP" || $type->getId() === "NPAI") {

                    /**
                     * @var Customer
                     */
                    $customer = $purchase->getCustomer();
                    $address = $ticket["address"];

                    $number = !empty($address["number"]) ? $address["number"] : $customer->getAddress()->getStreetNumber();
                    $street = !empty($address["street"]) ? $address["street"] : $customer->getAddress()->getStreetName();
                    $postal = !empty($address["postal"]) ? $address["postal"] : $customer->getAddress()->getCity()->getPostCode();
                    $cog = !empty($address["cog"]) ? $address["cog"] : $customer->getAddress()->getCity()->getCog();
                    $city = !empty($address["city"]) ? $address["city"] : $customer->getAddress()->getCity()->getName();

                    $obj_city = CityManager::getOneBy(["COG" => $cog, "postCode" => $postal]);
                    if (!$obj_city) $obj_city = CityManager::insert(new City($cog, $postal, $city));

                    $obj_address = AddressManager::getOneBy([
                        "address.streetNumber"  => $number,
                        "address.streetName"    => $street,
                        "address.COG"      => $cog,
                        "address.postCode" => $postal
                    ]);

                    if (!$obj_address) {

                        $obj_address = AddressManager::insert(
                            new Address(
                                $obj_city,
                                $street,
                                $number
                            )
                        );

                        $customer->setAddress($obj_address);
                        $customer = CustomerManager::update($customer);
                    }

                    $obj_ticket->addAction(
                        new UserAction(
                            ActionManager::getOneBy(["actionID" => 6]),
                            null,
                            null,
                            null,
                            "Réexpédition à: ". $customer->getAddress()
                        )
                    );

                } else if ($type->getId() === "EC") {

                    $obj_ticket->addAction(
                        new UserAction(
                            ActionManager::getOneBy(["actionID" => 4]),
                            null,
                            null,
                            null,
                            "Remboursement de ". ($article->getPrice() / 100) * $qty . "€"
                        )
                    );
                }

                $inserted[$i] = TicketManager::insert($obj_ticket)->getId();
            }

            echo json_encode($inserted);
            exit();
        }

        include "views/create_ticket.php";
    }
}