<?php $pageTitle = "Accueil"; ?>

<?php require_once "views/includes/start_html.php"; ?>

<!--   BODY   -->
<?php require_once "views/admin/header.php"; ?>

<main role="main">
    <?php require_once "views/templates/main_title.php"; ?>

    <section id="admin-home" class="card">

    <div class="card-header">

        <h2>Liste des utilisateurs</h2>
    </div>

    <div class="card-body">
        <h3><a href="./?p=user&action=create"><i class="fas fa-plus"></i> Créer un utilisateur</a></h3><br />
        <?php if ($users): ?>
    
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Rôle</th>
                  
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($users as $u): ?>
                        <tr>

                            <td><?= $u->getId(); ?></td>
                            <td><?= $u->getLastName(); ?></td>
                            <td><?= $u->getFirstName(); ?></td>
                            <td><?= $u->getRole()->getName(); ?></td>
                     
                            <td><i class="fa-solid fa-square-arrow-up-right" id=<?=$u->getId() ?>></i></td>
                            <?php if($u->getId() !== $user->getId()):?>
                                <td><i class="fa-solid fa-trash-can" name=<?=$u->getFirstName() . "*" . $u->getLastName() ?> id=<?=$u->getId() ?>></i></td>
                            <?php endif ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        <?php else: ?>
            <p>Aucun utilisateurs</p>
        <?php endif; ?>
        
    </div>

    </section>

</main>
    <?php require_once "views/templates/footer.php"; ?>
    <script src="./assets/js/admin_home.js"></script>
<!--   /BODY   -->
<?php require_once "views/includes/end_html.php"; ?>