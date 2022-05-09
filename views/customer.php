<?php $pageTitle = "Détail client"; ?>

<?php require_once "includes/start_html.php"; ?>

<!--   BODY   -->
    <?php require_once "templates/header.php"; ?>
<body>
    

    <main>

        <?php require_once "templates/main_title.php"; ?>
        
        
        <section id ="client-informations">
            <div><span>Nom client : </span><span class="bold"> <?php echo $customer->getFullName() ?> </span></div>
            <div><span> Numéro de téléphone : </span>  <span class="bold"> <?php echo $customer->getPhoneNumber() ?>  </span> </div>
            <div><span>Adresse du client : </span><span class="bold"> <?php echo $customer->getAddress() ?> </span></div>
        </section>

        <section id="client-purchases">
            <p class="bold"> Commandes passées par ce client : </p>
   
            <?php
  
            foreach($customer->getPurchases() as $purchase) {

            ?>
                <div class="client-purchase">
                    <div class="detail-subtittle">
                        <div class="bold"><?php echo "Commande n° " . $purchase->getId() ." du " . $purchase->getDate()->format("d/m/Y");?></div>
                        <div><i class="fa-solid fa-arrow-down"></i></div>
                    </div>
        
                    <div class="detail-purchase-hidden">

                        <?php
                        if($purchase->getTickets() !== "") {
                            foreach($purchase->getTickets() as $ticket) {
                                if($ticket->getArticle() == null) {
                    ?>
                                <a href=<?php echo "./?p=ticket&action=show&id=" . $ticket->getId(); ?> class="link-ticket-allpurchase"> <?php echo "Voir ticket n° " .$ticket->getId()." sur cette commande"; ?></a>
                    <?php
                                }
                            } 
                        }
                            foreach($purchase->getArticles() as $purchaseArticle) {

                        ?>
                            <div class="detail-article">
                            <div><?php echo $purchaseArticle->getArticle()->getName()?> </div>
                            <div><?php echo "Qté : " . $purchaseArticle->getQuantity() ?></div>
                            </div>
                        <?php 
                                foreach($purchase->getTickets() as $ticket) {
                                    if($ticket->getArticle() !== null) {
                                        if($ticket->getArticle()->getId() === $purchaseArticle->getArticle()->getId()) {
                        ?>
                                        <a href=<?php echo "./?p=ticket&action=show&id=" . $ticket->getId(); ?> class="link-ticket"> <?php echo "Voir ticket n° " .$ticket->getId()." sur cet article"; ?></a>
                        <?php
                                        }
                                    } 
                                }
                                      
                            }
                            
                            
                        ?>

                        <a href="./?p=purchase&action=show&id=<?= $purchase->getId() ?>" class="btn btn-primary">+ de détails</a>
                    
                    </div>
                </div>
            <?php
            }
            ?>
   
        </section>
        

    </main>
</body>

    <?php require_once "templates/footer.php"; ?>
<!--   /BODY   -->
<script src="./assets/js/customer.js"></script>
<?php require_once "includes/end_html.php"; ?>