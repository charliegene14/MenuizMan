<?php

namespace App\Controller\Article;

use App\Manager\ArticleManager;
use App\Exception\NotFoundException;
use App\Manager\StorageManager;
use App\Manager\StoredArticleManager;

class ArticleController {

    /**
     * Main controller of single article page.
     * Actions:
     *  + show - for showing page
     *  + upt-stocks - for update stocks
     *
     * @return void
     */
    public static function main() {

        global $user;

        $action = isset($_GET["action"]) ? htmlentities($_GET["action"]) : null;

        switch ($action) {

            case "show":

                if (!isset($_GET["id"]) || empty($_GET["id"])) throw new NotFoundException();
                $id = $_GET["id"];

                $article = ArticleManager::getOneBy(["articleID" => $id]);
         
                if (!$article) throw new NotFoundException();

                $stockPhy = StoredArticleManager::getOneBy([
                    "articleID" => $id,
                    "storageID" => 2
                ]);
                if (!$stockPhy) $stockPhy = 0;

                $stockSAV = StoredArticleManager::getOneBy([
                    "articleID" => $id,
                    "storageID" => 1
                ]);
                if (!$stockSAV) $stockSAV = 0;

                $stockRebus = StoredArticleManager::getOneBy([
                    "articleID" => $id,
                    "storageID" => 3
                ]);
                if (!$stockRebus) $stockRebus = 0;

                if (isset($_POST["action"]) && $_POST["action"] === "ajax_add_replacement") {

                    $articleToAdd = ArticleManager::getOneBy(["articleID" => $_POST["addID"]]);

                    if (!$articleToAdd) {
                        echo json_encode(false);
                        exit();
                    }

                    $article->addReplacement($articleToAdd);
                    ArticleManager::update($article);

                    echo json_encode(true);
                    exit();
                }

                include "views/article.php";
                break;

            case "upt_stocks":

                $id = isset($_GET["id"]) ? $_GET["id"] : null;
                if (!$id) throw new NotFoundException();

                header("Location: ./?p=article&action=show&id=" . $id);

                $stockPhy = StoredArticleManager::getOneBy(["articleID" => $id, "storageID" => 2]);
                $stockReb = StoredArticleManager::getOneBy(["articleID" => $id, "storageID" => 3]);
                $stockSAV = StoredArticleManager::getOneBy(["articleID" => $id, "storageID" => 1]);

                if (intval($_POST["stockPhy"]) !== $stockPhy->getQuantity()) {

                    $stockPhy->setQuantity(intval($_POST["stockPhy"]));

                    StoredArticleManager::update(
                        $stockPhy,
                        StorageManager::getOneBy(["storageID" => 2])
                    );

                }

                if (intval($_POST["stockSAV"]) !== $stockSAV->getQuantity()) {

                    $stockSAV->setQuantity(intval($_POST["stockSAV"]));

                    StoredArticleManager::update(
                        $stockSAV,
                        StorageManager::getOneBy(["storageID" => 1])
                    );
                }

                if (intval($_POST["stockReb"]) !== $stockReb->getQuantity()) {

                    $stockReb->setQuantity(intval($_POST["stockReb"]));

                    StoredArticleManager::update(
                        $stockReb,
                        StorageManager::getOneBy(["storageID" => 3])
                    );
                }
                
                exit();
                break;
            
            default:
                throw new NotFoundException();
        }
    }
}