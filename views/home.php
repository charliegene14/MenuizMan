<?php $pageTitle = "Accueil"; ?>

<?php require_once "includes/start_html.php"; ?>

<!--   BODY   -->
<?php require_once "templates/header.php"; ?>

<main>
    <?php require_once "templates/main_title.php"; ?>
    <div id="home-ticket-tables">
        <div>
        <h2  class="table-home-section" id="urgent-home-title">
            Urgent (<?= count($urgentTickets) ?>)
            <i class="fa-solid fa-triangle-exclamation"></i>
        </h2>
        <table class="table table-hover" id="table-home-urgent">
            <thead>
                <tr>
                    <th scope="col">N°Ticket</th>
                    <th scope="col">Type</th>
                    <th scope="col">N°Commande</th>
                    <th scope="col">Client</th>
                </tr>
            </thead>
            <tbody>

            <?php foreach($urgentTickets as $urgentTicket): ?>

                <?php $customer = $urgentTicket->getPurchase()->getCustomer(); ?>

                <tr>
                    <td><a href="./?p=ticket&action=show&id=<?= $urgentTicket->getId() ?>"><?= $urgentTicket->getId() ?></a></td>
                    <td><?= $urgentTicket->getType()->getId(); ?></td>
                    <td><a href="./?p=purchase&action=show&id=<?= $urgentTicket->getPurchase()->getId() ?>"><?= $urgentTicket->getPurchase()->getId() ?></a></td>
                    <td><a href="./?p=customer&id=<?= $customer->getId() ?>"><?= $customer->getFirstName() . " " .$customer->getLastName() ?></a></td>
                </tr>

            <?php endforeach; ?>

            </tbody>
        </table>
        </div>
        <div>
        <h2  class="table-home-section">En cours (<?= count($inProgressTickets) ?>) </h2>
        <table class="table table-hover" id="table-home">
            <thead>
                <tr>
                    <th scope="col">N°Ticket</th>
                    <th scope="col">Type</th>
                    <th scope="col">N°Commande</th>
                    <th scope="col">Client</th>
                </tr>
            </thead>
            <tbody>
            
            <?php foreach($inProgressTickets as $inProgressTicket): ?>

                <?php $customer = $inProgressTicket->getPurchase()->getCustomer(); ?>

                <tr>
                    <td><a href="./?p=ticket&action=show&id=<?= $inProgressTicket->getId() ?>"><?= $inProgressTicket->getId() ?></a></td>
                    <td><?= $inProgressTicket->getType()->getId(); ?></td>
                    <td><a href="./?p=purchase&action=show&id=<?= $inProgressTicket->getPurchase()->getId() ?>"><?= $inProgressTicket->getPurchase()->getId() ?></a></td>
                    <td><a href="./?p=customer&id=<?= $customer->getId() ?>"><?= $customer->getFirstName() . " " .$customer->getLastName() ?></a></td>
                </tr>

            <?php endforeach; ?>
            </tbody>
        </table>
        </div>
    </div>
   
    

</main>
    <?php require_once "templates/footer.php"; ?>
<!--   /BODY   -->
<?php require_once "includes/end_html.php"; ?>