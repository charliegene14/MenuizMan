<div class="ticket-action choice" id="action-129">
    <div class="ticket-action-left">
        <p>
            <span class="user">
                Tâche suivante...
            </span>
        </p>
    </div>

    <div class="ticket-action-right">
        <i class="fa-solid fa-circle"></i>
        <i class="fa-solid fa-caret-left"></i>
        <form action="?p=ticket&action=choice" method="post" id="choice-form">
            <p>
                <span class="action"><b>Choisir la tâche :</b></span>
                <br />
                
                    <select name="newTask" id="newTask">
                        <option value="2">Réception</option>
                        <option value="3">Diagnostic</option>
                        <option value="4">Remboursement</option>
                        <option value="5">Remplacement</option>
                        <option value="6">Réexpedition</option>
                    </select>
                    <input type="hidden" name="ticketID" value=<?=$ticket->getId() ?>>
                    </br>
                    <input type="button" class="btn btn-primary" id="choice-submit" value="Valider">      
            </p>
        </form>
    </div>
</div>