<div class="ticket-action" id="action-127">

                    <div class="ticket-action-left">
                        <p>
                            <span class="user"><?= $action->getUser()->getLastName() . " " . $action->getUser()->getFirstName()?></span>
                            <br />
                            <span class="datetime"><?= $action->getEnd()->format("d/m/Y H:i:s") ?></span>
                            
                        </p>
                    </div>

                    <div class="ticket-action-right">

                        <i class="fa-solid fa-circle"></i>
                        <i class="fa-solid fa-caret-left"></i>
                        <p>
                            <span class="action"><b><?= $action->getAction()->getType() ?></b></span>
                            <br />
                            <span class="action-detail"><?= $action->getCommentary()?><br />Terminé</span>
                        </p>
                    </div>

                </div>

                