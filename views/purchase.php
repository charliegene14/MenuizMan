<?php

$pageTitle = "Commande n°" . $id; ?>

<?php require_once "includes/functions.php"; ?>
<?php require_once "includes/start_html.php"; ?>

<!--   BODY   -->
    <?php require_once "templates/header.php"; ?>
<body>
    

    <main role="main" id="purchase">

        <?php require_once "templates/main_title.php"; ?>
        
        <section class="card" id="customer-infos">
            <div class="card-header">

                <h2>Client</h2>
            </div>

            <div class="card-body">

                <div><span>Nom: </span><span class="bold"> <?= $purchase->getCustomer()->getFullName() ?> </span></div>
                <div><span> Numéro de téléphone : </span>  <span class="bold"> <?= $purchase->getCustomer()->getPhoneNumber() ?>  </span> </div>
                <div><span>Adresse: </span><span class="bold"> <?= $purchase->getCustomer()->getAddress() ?> </span></div>
                <div><span><a href="./?p=customer&id=<?= $purchase->getCustomer()->getId() ?>">Détail client</a></span></div>
            </div>
        </section>

        <section class="card" id="purchase-infos">
            <div class="card-header">
                
                <h2>Commande</h2>
            </div>

            <div class="card-body">

                <div><span>N° </span><span class="bold"> <?= $id?> </span></div>
                <div><span>Date : </span>  <span class="bold"> <?= $purchase->getDate()->format("d/m/Y H:i:s") ?> </span></div>
                <div><span>Paiement : </span>  <span class="bold"> <?= $purchase->getPaymentStatus() ? "Payé" : "Non payé" ?> </span></div>
                <div><span>Facture n° </span>  <span class="bold"> <?= $purchase->getInvoice() ?> </span></div>

                <a style="color: var(--white)!important; float: right" href="./?p=ticket&action=create&purchase_id=<?= $purchase->getId() ?>" class="btn btn-primary">Créer un ticket</a>
            </div>
        </section>

        <section class="card" id="purchase-articles">
            <div class="card-header">
                
                <h2>Articles</h2>
            </div>

            <div class="card-body">

                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Nom</th>
                            <th scope="col">Prix u.</th>
                            <th scope="col">Qté</th>
                            <th scope="col">Total</th>
                        </tr>
                    </thead>
                    <tbody>
    
                        <?php
    
                        foreach ($purchase->getArticles() as $pArticle) {
    
                            echo "<tr>";
                            echo "<td>"  . $pArticle->getArticle()->getId() . "</td>";
                            echo "<td><a href='./?p=article&action=show&id=" .$pArticle->getArticle()->getId(). "'>"  . $pArticle->getArticle()->getName() . "</a><br />";
    
                            article_show_recursive($pArticle->getArticle()->getComposition(), 0);
    
                            echo "</td>";
    
                            echo "<td>"  . $pArticle->getArticle()->getPrice() / 100 . " €</td>";
                            echo "<td>"  . $pArticle->getQuantity() . "</td>";
                            echo "<td>"  . ($pArticle->getArticle()->getPrice() *  $pArticle->getQuantity()) / 100 . " €</td>";
    
                            echo "</tr>";
                        }
                        ?>
    
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4">Prix total</td>
                            <td><?= $purchase->getTotalPrice() / 100 ?> €</td>
                        </tr>
                    </tfoot>
                </table>
            </div>


        </section>
         
    </main>
</body>

    <?php require_once "templates/footer.php"; ?>
<!--   /BODY   -->
<?php require_once "includes/end_html.php"; ?>