<?php $pageTitle = "Connexion"; ?>

<?php require_once "includes/start_html.php"; ?>

<!--   BODY   -->

    <main role="main" id="login">

        <div class="container">

            <div id="logo">
                <img src="./assets/img/logo_sm.png" alt="Logo Menuiz Man">
            </div>
            
            <h1>Connexion</h1>

            <form method="post">

                <div id="form-id">
                    <label for="id">Identifiant:</label>
                    <input class="form-control" type="text" name="login" id="id" />
                </div>

                <div id="form-password">
                    <label for="password">Mot de passe:</label>
                    <input class="form-control" type="password" name="password" id="password" />
                </div>

                <button type="submit"><i class="fa-solid fa-circle-arrow-right"></i></button>
            </form>

        </div>

    </main>

    <script src="./assets/js/login.js"></script>
    <?php require_once "templates/footer.php"; ?>
<!--   /BODY   -->
<?php require_once "includes/end_html.php"; ?>