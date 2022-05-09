<?php $pageTitle = "Recherche"; ?>

<?php require_once "includes/start_html.php"; ?>

<!--   BODY   -->

<?php require_once "templates/header.php"; ?>

<main id="main-div-search">
    <?php require_once "templates/main_title.php"; ?>
    <div id="btn-nav-search">
        <div class="nav-form" name="tickets_form">Tickets</div>
        <div class="nav-form" name="customers_form">Clients</div>
        <div class="nav-form" name="purchases_form">Commandes</div>
        <div class="nav-form" name="articles_form">Articles</div>
    </div>

    <?php if($hasSearch){
           require_once "templates/search_forms/search_results.php";
    }
    ?>
    <div id="search-form"></div>
   
    
</main>
<?php require_once "templates/footer.php"; ?>

<script src="./assets/js/search.js"></script>
<!--   /BODY   -->
<?php require_once "includes/end_html.php"; ?>