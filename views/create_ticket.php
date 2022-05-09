<?php $pageTitle = "Nouveau ticket"; ?>

<?php require_once "includes/start_html.php"; ?>

<!--   BODY   -->
    <?php require_once "templates/header.php"; ?>

    <main role="main" id="create-ticket">

        <?php require_once "templates/main_title.php"; ?>

        <div id="first-inputs">
            <!-- INPUT PURCHASE ID -->
            <form id="purchase" class="needs-validation">

                <label for="input-purchase" class="form-label">N° de commande</label>

                <div class="input-container">

                    <input
                        class="form-control"
                        type="text"
                        name="purchaseID"
                        placeholder="Rechercher une commande"
                        id="input-purchase"
                        <?= isset($purchase) && !empty($purchase) ? "value=" .$purchase->getId()." disabled" : null ?>
                    />

                    <p class="invalid-feedback
                        <?= isset($_GET["purchase_id"]) && empty($purchase) ? " active" : null ?>"
                        id="error-purchase" >Le n° de commande saisi est incorrect.
                    </p>

                    <div id="purchase-autocomplete" class="">
                        <ul>
                        </ul>
                    </div>

                </div>

            </form>

            <!-- INPUT TICKET TYPE -->
            <?php if (isset($purchase) && !empty($purchase)): ?>

            <form
                method="get"
                class="needs-validation"
                onchange="submit()"
            >

                <label for="input-type" class="form-label">Type de problème</label>

                <div class="input-container">

                    <select
                        class="form-control"
                        name="ticket_type"
                        id="input-type"
                        <?= $type ? " disabled" : null ?>
                    >
                        <option>-- Choisir un type -- </option>

                        <?php foreach ($typeList as $t): ?>
                            <option
                                value="<?= $t->getId(); ?>"
                                <?= $ticketType && $t->getId() === $ticketType ? " selected" : null ?>
                            >
                                <?= $t->getId() . " - " . $t->getName(); ?>
                            </option>
                        <?php endforeach; ?>

                    </select>

                    <input type="hidden" name="p" value="ticket">
                    <input type="hidden" name="action" value="create">
                    <input type="hidden" name="purchase_id" value="<?= $purchase->getId() ?>">

                    <p class="invalid-feedback
                        <?= $ticketType && !$type ? " active" : null ?>"
                        id="error-type" >Ce type de problème n'existe pas.
                    </p>

                </div>

            </form>
            <?php endif; ?>
        </div>

        <?php if (isset($purchase) && !empty($purchase) && isset($type) && !empty($type)): ?>

        <div id="tickets-list-container">

            <form id="all-tickets" class="needs-validation">
                <div id="ticket-list">

                    <?php include "views/templates/create_tickets_forms/ticket_form.php"; ?>

                </div>

                <?php if ($type->getId() !== "NPAI" && $type->getId() !== "NP"): ?>

                <div id="add-ticket">
                    <i class="fas fa-plus"></i>
                    &nbsp;Ajouter un problème
                </div>

                <?php endif; ?>

                <div id="submit">
                    
                    <input type="hidden" name="purchaseID" value="<?= $purchase->getId() ?>">
                    <input type="hidden" name="ticketType" value="<?= $type->getId() ?>">
                    <input id="submitTicket" class="btn btn-success" type="submit" value="Valider" />
                </div>

            </form>

        </div>

        <?php endif; ?>

    </main>

    <?php require_once "templates/footer.php"; ?>

    <script src="./assets/js/create_ticket.js"></script>
<!--   /BODY   -->
<?php require_once "includes/end_html.php"; ?>