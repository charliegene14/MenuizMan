<div class="ticket-action inwork" id="action-128">
                    <div class="ticket-action-left">
                        <p>
                          
                            <?php  
                                if($user->getId() === $action->getUser()->getId() && $user->getRole()->getId() === "AST") {
                            ?>
                                <a href=<?="?p=ticket&action=endTask&ticketID=" . $ticket->getId() . "&doID=" . $action->getId()?>>Termniner la tâche</a><br />
                                <a href=<?="?p=ticket&action=leaveTask&ticketID=" . $ticket->getId() . "&doID=" . $action->getId()?>>Abandonner la tâche</a><br />
                            <?php
                                } else {
                            ?>
                                    <span class="user"><?=$action->getUser()->getLastName() . " " . $action->getUser()->getFirstName() ?></span>
                                    <br />
                                    <span class="datetime"><?= $action->getStart()->format("d/m/Y H:i:s") ?></span>
                            <?php
                                    if($user->getRole()->getId() === "MNG"){
                            ?>
                                </br><a href=<?="?p=ticket&action=endTask&ticketID=" . $ticket->getId() . "&doID=" . $action->getId()?>>Termniner la tâche</a><br />
                                <a href=<?="?p=ticket&action=changeTask&ticketID=" . $ticket->getId() . "&doID=" . $action->getId()?>>Supprimer la tâche</a><br />
                                <a href=<?="?p=ticket&action=leaveTask&ticketID=" . $ticket->getId() . "&doID=" . $action->getId()?>>Désaffecter la tâche</a><br />
                            <?php
                                    }
                                }
                                $bLastAction =false;
                            ?>
                        </p>
                    </div>

                    <div class="ticket-action-right">

                        <i class="fa-solid fa-circle"></i>
                        <i class="fa-solid fa-caret-left"></i>
                        <p>
                            <span class="action"><b><?= $action->getAction()->getType() ?></b></span>
                            <br />
                            <span class="action-detail"><?= $action->getCommentary() ? $action->getCommentary() . "<br />" : null ?>
                En cours...</span>
                        </p>
                    </div>
                </div>