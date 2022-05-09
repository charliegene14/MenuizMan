<?php

$pageTitle = "Article n°" . $id; ?>

<?php require_once "includes/functions.php"; ?>
<?php require_once "includes/start_html.php"; ?>

<!--   BODY   -->
    <?php require_once "templates/header.php"; ?>
<body>
    

    <main role="main" id="article">

        <?php require_once "templates/main_title.php"; ?>

        <section class="card" id="article-infos">
            <div class="card-body">

                <div><span>N° </span><span class="bold"> <?= $id?> </span><i name=<?= $id?> id="copy-articleID" class="fa-solid fa-copy"></i> <span id="mess-copied">ID Article copié</span></div>
                <div><span>Nom : </span><span class="bold"> <?= $article->getName(); ?> </span></div>
                <div><span>Prix : </span><span class="bold"> <?= $article->getPrice() / 100; ?> €</span></div>
                <div><span>Garantie : </span><span class="bold"> <?= $article->getGuarDuration() ? $article->getGuarDuration() . " mois" : "Aucune" ?></span></div>
                <div><span>Note 1 : </span><span class="bold"> <?= $article->getNote(1) ?  $article->getNote(1) : "Aucune" ?></span></div>
                <div><span>Note 2 : </span><span class="bold"> <?= $article->getNote(2) ?  $article->getNote(2) : "Aucune" ?></span></div>
            </div>
        </section>

        <section class="card" id="article-storage">
            <div class="card-header">
                <h2>Stocks</h2>
            </div>
            <div class="card-body">
                <form action="/index.php?p=article&action=upt_stocks&id=<?= $id ?>" method="post">
                
                <table class="table" id="table-storage">

                    <tbody>
                        <tr>
                            <td>Stock physique</td>
                            <td><i class="fas fa-minus phy remove"></i></td>
                            <td><input
                                    class="form-control"
                                    name="stockPhy"
                                    style="width: 6rem; text-align: right"
                                    type="number"
                                    id="phy-value"
                                    value="<?= $stockPhy->getQuantity() ?>" />
                            </td>
                            <td><i class="fas fa-plus phy add"></i></td>

                        </tr>

                        <tr>
                            <td>Stock SAV</td>
                            <td><i class="fas fa-minus sav remove"></i></td>
                            <td><input
                                    class="form-control"
                                    name="stockSAV"
                                    style="width: 6rem; text-align: right"
                                    type="number"
                                    id="sav-value"
                                    value="<?= $stockSAV->getQuantity() ?>" />
                            </td>
                            <td><i class="fas fa-plus sav add"></i></td>
                        </tr>

                        <tr>
                            <td>Stock Rebus</td>
                            <td><i class="fas fa-minus reb remove"></i></td>
                            <td><input
                                    class="form-control"
                                    name="stockReb"
                                    style="width: 6rem; text-align: right"
                                    type="number"
                                    id="reb-value"
                                    value="<?= $stockRebus->getQuantity() ?>" />
                            </td>
                            <td><i class="fas fa-plus reb add"></i></td>
                        </tr>
                    </tbody>
                </table>

                <input class="btn btn-primary" style="float: right" type="submit" value="Appliquer">
                </form>
            </div>

            
        </section>

        <section class="card" id="article-composition">
            <div class="card-header">
                <h2>Composition</h2>

            </div>

            <div class="card-body">

            
                <?php if ($article->getComposition()): ?>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Nom</th>
                                <th scope="col">Prix u.</th>
                                <th scope="col">Qté</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                                foreach ($article->getComposition() as $cArticle) {

                                    echo "<tr>";
                                    echo "<td>"  . $cArticle->getArticle()->getId() . "</td>";
                                    echo "<td><a href='./?p=article&action=show&id=" .$cArticle->getArticle()->getId().  "'>"  . $cArticle->getArticle()->getName() . "</a><br />";
            
                                    article_show_recursive($cArticle->getArticle()->getComposition(), 0);
            
                                    echo "</td>";
            
                                    echo "<td>"  . $cArticle->getArticle()->getPrice() / 100 . " €</td>";
                                    echo "<td>"  . $cArticle->getQuantity() . "</td>";
            
                                    echo "</tr>";
                                }
                            ?>

                        </tbody>
                        <tfoot>
                            <tr>
                            
                            </tr>
                        </tfoot>
                    </table>
                <?php else: ?>
                    <p>Aucune composition</p>
                <?php endif; ?>

            </div>
        </section>

        <section class="card" id="article-replace">
            <div class="card-header">

                <h2>Peut être remplacé...</h2>
            </div>

            <div class="card-body">

                <?php if ($article->getReplacements()): ?>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Nom</th>
                                <th scope="col">Prix u.</th>
                            </tr>
                        </thead>
                        <tbody>
    
                            <?php
                                foreach ($article->getReplacements() as $article) {
                                    echo "<tr>";
    
                                    echo "<td>".$article->getId()."</td>";
                                    echo "<td><a href='./?p=article&action=show&id=".$article->getId()."'>".$article->getName()."</a></td>";
                                    echo "<td>".$article->getPrice() / 100 ."€</td>";
                                    echo "</tr>";
                                }
                            ?>
    
                        </tbody>
                        <tfoot>
                            <tr>
                            
                            </tr>
                        </tfoot>
                    </table>
                <?php else: ?>
                    <p>Aucun remplacment</p>
                <?php endif; ?>
    
                <form id="add-replace" method="post">
                    <label for="articleID">Ajouter un article de remplacement</label>
                    <div class="messerror" id="messerror" style="display:none">Cet article n'existe pas</div>
                    <input class="form-control" type="text" name="articleID" placeholder="Identifiant d'article">
                    <input class="btn btn-primary" style="float: right" type="submit" value="Ajouter">
                </form>
            </div>
        </section>
        
        
    </main>
</body>

<script src="./assets/js/article.js"></script>
    <?php require_once "templates/footer.php"; ?>
<!--   /BODY   -->
<?php require_once "includes/end_html.php"; ?>