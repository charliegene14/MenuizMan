<?php $pageTitle = "Ticket n°" . $id; ?>

<?php require_once "includes/start_html.php"; ?>

<!--   BODY   -->
    <?php require_once "templates/header.php"; ?>

    <main role="main" id="ticket">

        <?php require_once "templates/main_title.php"; ?>

        <div id="ticket-container">

            <div id="ticket-infos">
                <?="Commande n°" . $purchase ?> (<a href=<?="?p=purchase&action=show&id=$purchase" ?>>voir</a>)
            <?php   
                if(!is_null($article)){
            ?>
                <p>Article n° <?=$article ?> (<a href=<?="?p=article&action=show&id=$article" ?>>voir</a>)</p></br>
            <?php
                }else {
            ?>
                </br>
            <?php
                }
            ?>    
                <?php
                
                ?>                   
                <span class="bold"><?=$type?></span>
                <br />
                <?=$comment ?>
            </div>
            
            <div id="ticket-actions-list">
            <?php 
                $bworkingON = true;
                $bLastAction = true;
                foreach ($actions as $action) {
                    $action->getAction()->getId()===7?$bEnd = true : $bEnd =false;
                    
                    if ($action->isTodo()) {       
                        $bEnd = true;               
                        include "views/templates/ticket_actions/todo_action.php";

                    } elseif ($action->onDoing()) {
                        $bworkingON = false;
                        $bEnd = true;
                        include "views/templates/ticket_actions/inwork_action.php";

                    } elseif ($action->isDone()) {
                        include "views/templates/ticket_actions/done_action.php";

                    } 
                }

                if(!$bEnd && $user->getRole()->getId() === "AST" ) include "views/templates/ticket_actions/choice_action.php";
                
            ?>

            </div>
            <?php  
                if($closed) {
            ?>
                <i class="fa-solid fa-clipboard-check" id="check"></i>
            <?php
                } elseif($bworkingON && $user->getRole()->getId() !== "HLT"){
            ?>
               <a id="close" href=<?="?p=ticket&action=close&id=".$ticket->getId() ?>>Clôturer ce ticket</a>
            <?php
                }

                if ($user->getRole()->getId() === "MNG" && !$ticket->isClosed()) {

                    if ($ticket->isUrgent()) {
                        echo "<a style='display: flex; justify-content: center' href='./?p=ticket&action=urgent&id=" .$ticket->getID(). "'>Enlever l'urgence</a>";
                    } else {
                        echo "<a style='display: flex; justify-content: center' href='./?p=ticket&action=urgent&id=" .$ticket->getID(). "'>Traiter en urgence</a>";

                    }
                }
            ?>
            
        </div>

    </main>

    <?php require_once "templates/footer.php"; ?>
    <script src="./assets/js/ticket.js"></script>
<!--   /BODY   -->
<?php require_once "includes/end_html.php"; ?>