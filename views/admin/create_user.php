<?php $pageTitle = "Créer un utilisateur"; ?>

<?php require_once "views/includes/start_html.php"; ?>

<!--   BODY   -->
<?php require_once "views/admin/header.php"; ?>

<main role="main">
    <?php require_once "views/templates/main_title.php"; ?>

    <?php if (isset($_GET["success"])): ?>
        <p style="color: var(--bs-success)">Utilisateur créé avec succès !</p>
    <?php endif; ?>

    <form id="form-user" method="post" action="./?p=user&action=create&create=true">

        <?php include "views/admin/user_form.php" ?>

    </form>

</main>

    <script src="./assets/js/user.js"></script>
    <?php require_once "views/templates/footer.php"; ?>

<!--   /BODY   -->
<?php require_once "views/includes/end_html.php"; ?>