<div class="ticket-action todo" id="action-129">
    <div class="ticket-action-left">
        <p>
            <span class="user">
               
                <?php 
               
                if($bLastAction && $user->getRole()->getId() === "AST") { ?> 
                    <a id="do-task-link" href=<?="?p=ticket&action=doTask&ticketID=" . $ticket->getId() . "&doID=" . $action->getId()?>>Réaliser la tâche</a><br />
                    <a href=<?="?p=ticket&action=changeTask&ticketID=" . $ticket->getId() . "&doID=" . $action->getId()?>>Changer la tâche</a>
                <?php 
                $bLastAction=false;
                }
                ?>
                
            </span>
        </p>
    </div>

    <div class="ticket-action-right todo-action">

        <i class="fa-solid fa-circle"></i>
        <i class="fa-solid fa-caret-left"></i>
        <p>
            <span class="action"><b><?=$action->getAction()->getType() ?></b></span><br />

            <?php if ($action->getAction()->getId() === 5 && $ticket->getType() !== "NP" && $ticket->getType() !== "NPAI"): ?>

            <label for="articleID_replace">Remplacer par l'article (ID)</label>
            <span id="input-container">
            <input class="form-control" type="text" size="5" id="articleID_replace" name="articleID_replace" value="<?= $ticket->getArticle()->getId() ?>">
            <i id="paste-img" class="fa-solid fa-paste"></i>
            </span>
            <?php endif; ?>
            <?php if (isset($_GET["replace_err"])) echo "<span class='messerror'>L'article saisi n'existe pas.</span><br />"; ?>
            <span class="action-detail"><?= $action->getCommentary() ? $action->getCommentary() . "<br />" : null ?>
                A effectuer</span>
        </p>
    </div>
</div>