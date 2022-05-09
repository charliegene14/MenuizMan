<?php $pageTitle = "Erreur"; ?>

<?php require_once "includes/start_html.php"; ?>

<!--   BODY   -->
    <?php require_once "templates/header.php"; ?>
    

    <main role="main" id="not-found">
    <?php require_once "templates/main_title.php"; ?>

            
            <p><?php echo $exception ?></p>


    </main>

    <?php require_once "templates/footer.php"; ?>
<!--   /BODY   -->
<?php require_once "includes/end_html.php"; ?>