
<?php $pageTitle = "Statistiques"; ?>

<?php require_once "includes/start_html.php"; ?>

<!--   BODY   -->    

    <?php require_once "templates/header.php"; ?>

    <main role="main" id="stats">
        <?php require_once "templates/main_title.php"; ?>


        <div id="charts-container">

            <div id="done">
                <canvas id="done-canvas"></canvas>
                <span>Finalisés<br /><?= $doneCount; ?></span>
            </div>
    
            <div id="inwork">
                <canvas id="inwork-canvas"></canvas>
            </div>
    
        </div>
        
        <!-- <div id="time">
            <canvas id="time-canvas"></canvas>
        </div> -->
    </main>

    <?php require_once "templates/footer.php"; ?>

<!--   /BODY   -->

    
<?php require_once "includes/end_html.php"; ?>

