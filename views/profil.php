<?php $pageTitle = "Mon profil"; ?>

<?php require_once "includes/start_html.php"; ?>

<!--   BODY   -->
<?php require_once "templates/header.php"; ?>

<main role="main" id="profil">

    <?php require_once "templates/main_title.php"; ?>

    <h2>Bonjour <?= $user->getFirstName() . " " . $user->getLastName() ?> !</h2>

    <?php if ($user->getRole()->getId() === "AST" ): ?>

    <section class="card" id="tasks">
        <div class="card-header">
            <h3>Vos tickets en cours (<?= count($tickets); ?>)</h3>

        </div>

        <div class="card-body">

            <?php if ($tickets): ?>
    
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
                    
                    <?php foreach($tickets as $ticket): ?>
    
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
            <?php else: ?>
                <p>Aucun ticket en cours actuellement</p>
            <?php endif; ?>
        </div>

    </section>
    <?php endif; ?>

    <section class="card" id="password-change">
        <div class="card-header">

            <h3>Votre mot de passe</h3>
        </div>

        <div class="card-body">
            <?php if ($hasError): ?>
                <div class="messerror"><?= $msgError ?></div>
            <?php endif; ?>
    
            <?php if ($hasChanged): ?>
                <div style="color: var(--bs-success)" class="messok">Mot de passe changé avec succès !</div>
            <?php endif; ?>
    
            <form action="./?p=profil&action=update_password" method="post">
                <label for="oldPassword">Mot de passe actuel</label>
                <input class="form-control" type="password" name="oldPassword" id="oldPassword" placeholder="Votre mot de passe">
        
                <label for="newPassword1">Nouveau mot de passe</label>
                <input class="form-control" type="password" name="newPassword1" id="newPassword1" placeholder="Votre nouveau mot de passe">
        
                <label for="newPassword2">Répétez votre nouveau mot de passe</label>
                <input class="form-control" type="password" name="newPassword2" id="newPassword2" placeholder="Votre nouveau mot de passe">
        
                <input class="btn btn-primary" type="submit" value="Valider">
    
            </form>

        </div>
    </section>

</main>

    <?php require_once "templates/footer.php"; ?>
<!--   /BODY   -->
<?php require_once "includes/end_html.php"; ?>