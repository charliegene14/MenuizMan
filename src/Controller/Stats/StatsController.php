<?php

namespace App\Controller\Stats;

use App\Manager\TicketManager;

class StatsController
{

    /**
     * Main controller for stats page
     *
     * @return void
     */
    public static function main() {

        global $user;

        $action = isset($_POST["action"]) ? $_POST["action"] : null;

        switch ($action) {

            case "ajax_get_done_chart_data":

                $doneCountNPAI  = TicketManager::getDoneCountOf("NPAI");
                $doneCountNP    = TicketManager::getDoneCountOf("NP");
                $doneCountEP    = TicketManager::getDoneCountOf("EP");
                $doneCountEC    = TicketManager::getDoneCountOf("EC");
                $doneCountSAV   = TicketManager::getDoneCountOf("SAV");

                echo json_encode([
                    "NPAI" => $doneCountNPAI,
                    "NP" => $doneCountNP,
                    "EC" => $doneCountEC,
                    "EP" => $doneCountEP,
                    "SAV" => $doneCountSAV
                ]);
       

                exit();
                break;

            case "ajax_get_inwork_chart_data":
               
                /**
                 * NPAI
                 */
                $workCountNPAIrecept    = TicketManager::getInWorkCount("NPAI", 2);
                $workCountNPAIdiag      = TicketManager::getInWorkCount("NPAI", 3);
                $workCountNPAIrepay     = TicketManager::getInWorkCount("NPAI", 4);
                $workCountNPAIreplace   = TicketManager::getInWorkCount("NPAI", 5);
                $workCountNPAIreship    = TicketManager::getInWorkCount("NPAI", 6);
                
                /**
                 * NP
                 */
                $workCountNPrecept      = TicketManager::getInWorkCount("NP", 2);
                $workCountNPdiag        = TicketManager::getInWorkCount("NP", 3);
                $workCountNPrepay       = TicketManager::getInWorkCount("NP", 4);
                $workCountNPreplace     = TicketManager::getInWorkCount("NP", 5);
                $workCountNPreship      = TicketManager::getInWorkCount("NP", 6);

                /**
                 * SAV
                */
                $workCountSAVrecept     = TicketManager::getInWorkCount("SAV", 2);
                $workCountSAVdiag       = TicketManager::getInWorkCount("SAV", 3);
                $workCountSAVrepay      = TicketManager::getInWorkCount("SAV", 4);
                $workCountSAVreplace    = TicketManager::getInWorkCount("SAV", 5);
                $workCountSAVreship     = TicketManager::getInWorkCount("SAV", 6);

                /**
                 * EC
                 */
                $workCountECrecept      = TicketManager::getInWorkCount("EC", 2);
                $workCountECdiag        = TicketManager::getInWorkCount("EC", 3);
                $workCountECrepay       = TicketManager::getInWorkCount("EC", 4);
                $workCountECreplace     = TicketManager::getInWorkCount("EC", 5);
                $workCountECreship      = TicketManager::getInWorkCount("EC", 6);


                /**
                * EP
                */
                $workCountEPrecept      = TicketManager::getInWorkCount("EP", 2);
                $workCountEPdiag        = TicketManager::getInWorkCount("EP", 3);
                $workCountEPrepay       = TicketManager::getInWorkCount("EP", 4);
                $workCountEPreplace     = TicketManager::getInWorkCount("EP", 5);
                $workCountEPreship      = TicketManager::getInWorkCount("EP", 6);

                $arr = [
                    "SAV" => [
                        "receive"       => $workCountSAVrecept,
                        "diagnostic"    => $workCountSAVdiag,
                        "repayment"     => $workCountSAVrepay,
                        "replacement"   => $workCountSAVreplace,
                        "reship"        => $workCountSAVreship
                    ],
                    "EC" => [
                        "receive"       => $workCountECrecept,
                        "diagnostic"    => $workCountECdiag,
                        "repayment"     => $workCountECrepay,
                        "replacement"   => $workCountECreplace,
                        "reship"        => $workCountECreship
                    ],
                    "EP" => [
                        "receive"       => $workCountEPrecept,
                        "diagnostic"    => $workCountEPdiag,
                        "repayment"     => $workCountEPrepay,
                        "replacement"   => $workCountEPreplace,
                        "reship"        => $workCountEPreship
                    ],
                    "NP" => [
                        "receive"       => $workCountNPrecept,
                        "diagnostic"    => $workCountNPdiag,
                        "repayment"     => $workCountNPrepay,
                        "replacement"   => $workCountNPreplace,
                        "reship"        => $workCountNPreship
                    ],
                    "NPAI" => [
                        "receive"       => $workCountNPAIrecept,
                        "diagnostic"    => $workCountNPAIdiag,
                        "repayment"     => $workCountNPAIrepay,
                        "replacement"   => $workCountNPAIreplace,
                        "reship"        => $workCountNPAIreship
                    ]
                ];

                echo json_encode($arr);

                exit();

                break;

            case "ajax_get_total_chart_data":

                exit();
                break;

        }

        $doneCount = TicketManager::getDoneCount();


        include "views/stats.php";
    }

}