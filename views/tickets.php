
<?php require_once "includes/start_html.php"; ?>

<!--   BODY   -->
<?php require_once "templates/header.php"; ?>

<main>
    <?php require_once "templates/main_title.php"; ?>
    <div id="home-ticket-tables">
        
        <div>
            <h2  class="table-home-section">Total : <?= count($ticketList) ?></h2>
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
                
                <?php foreach($ticketList as $ticket): ?>

                    <?php $customer = $ticket->getPurchase()->getCustomer(); ?>

                    <tr>
                        <td><a href="./?p=ticket&action=show&id=<?= $ticket->getId() ?>"><?= $ticket->getId() ?></a></td>
                        <td><?= $ticket->getType()->getId(); ?></td>
                        <td><a href='./?p=purchase&action=show&id=<?= $ticket->getPurchase()->getId() ?>'><?= $ticket->getPurchase()->getId() ?></a></td>
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