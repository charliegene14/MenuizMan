<?php

namespace App\Controller\Search;

use App\Entity\Article;
use App\Manager\ArticleManager;
use App\Exception\SearchException;
use App\Manager\StoredArticleManager;

class SearchArticleController {

    /**
     * Controller for searching articles according to filters
     *
     * @param array $filters
     * @return void
     */
    public static function search(array $filters) {

        $attributes = [];
        foreach($filters as $key => $value) {
            $filters[$key] = htmlspecialchars($value);
        }

        if ($filters["articleID"] !== "") {
            if (is_nan($filters["articleID"]) || $filters["articleID"] < 0)
                throw new SearchException("L'ID article doit être un entier positif");

            $attributes["articleID"] = $filters["articleID"];
        }

        if ($filters["articleName"] !== "") {
            if(strlen($filters["articleName"]) > 50 )
                throw new SearchException("Le nom de l'article ne peut pas contenir plus de 50 caractères");

            $attributes["articleName"] = $filters["articleName"];
        }

        if ($filters["articlePriceMin"] !== "") {
            if(is_nan($filters["articlePriceMin"]))
                throw new SearchException("Le prix minimum est incorrect");

            $minPrice = $filters["articlePriceMin"];
        }

        if ($filters["articlePriceMax"] !== "") {
            if (is_nan($filters["articlePriceMax"]) || $filters["articlePriceMax"] < 0)
                throw new SearchException("Le prix maximum est incorrect");

            $maxPrice = $filters["articlePriceMax"];
        }

        if (
            isset($attributes["articlePriceMin"], $attributes["articlePriceMax"])
            && $attributes["articlePriceMin"] > $attributes["articlePriceMax"]
        )
            throw new SearchException("Le prix minimum ne doit pas être supérieur au prix maximum");

        if (!empty($attributes)) {
            $articles = ArticleManager::searchBy($attributes);
        } else {
            $articles = ArticleManager::getAll();
        }

        $articlesAfterPrice = [];

        if (isset($minPrice) || isset($maxPrice)) {
            
            foreach ($articles as $article) {

                if (isset($minPrice) && isset($maxPrice)) {
                    if ($article->getPrice() > $minPrice *100
                        && $article->getPrice() < $maxPrice *100) {
                        $articlesAfterPrice[] = $article;
                    }
                    continue;
                }

                if (isset($minPrice)) {
                    if ($article->getPrice() > $minPrice *100) {
                        $articlesAfterPrice[] = $article;
                    }
                }
                if (isset($maxPrice)) {
                    if ($article->getPrice() < $maxPrice *100) {
                        $articlesAfterPrice[] = $article;
                    }
                }
            }

            $articles = $articlesAfterPrice;
        } 

        if (

            (isset($filters["form-inphys-search"]))
            || (isset($filters["form-insav-search"]))
            || (isset($filters["form-inrebus-search"]))
        ) {

            $articlesAfterStorages = [];

            foreach ($articles as $article) {
    
                $stored = null;
    
                if (isset($filters["form-inphys-search"])) {
    
                    $stored = StoredArticleManager::getOneBy([
                        "articleID" => $article->getId(),
                        "storageID" => 2
                    ]);
    
                    if ($stored && !empty($stored) && $stored->getQuantity() > 0) {
                        $articlesAfterStorages[] = $article;
                        continue;
                    }
                }
    
                if (isset($filters["form-insav-search"])) {
    
                    $stored = StoredArticleManager::getOneBy([
                        "articleID" => $article->getId(),
                        "storageID" => 1
                    ]);

                    if ($stored && !empty($stored) && $stored->getQuantity() > 0) {
                        $articlesAfterStorages[] = $article;
                        continue;
                    }
    
                }
                
                if (isset($filters["form-inrebus-search"])) {
    
                    $stored = StoredArticleManager::getOneBy([
                        "articleID" => $article->getId(),
                        "storageID" => 3
                    ]);

                    if ($stored && !empty($stored) && $stored->getQuantity() > 0) {
                        $articlesAfterStorages[] = $article;
                        continue;
                    }
                }
            }

            $articles = $articlesAfterStorages;
        }

        if (is_null($articles) || empty($articles))
            throw new SearchException("Aucun résultat pour cette recherche");

        return self::buildArticleDisplayTable($articles);
    }

    /**
     * Build the HTML table for display results
     *
     * @param array $articles
     * @return void
     */
    private static function buildArticleDisplayTable(array $articles) {

        /**
         * @var Article
         */
        foreach ($articles as $article) {

            $table = [
                "Article n°" . $article->getId(),
                "<span class='bold'>Nom : </span>" . $article->getName(),
                "<span class='bold'>Prix : </span>" . $article->getPrice() / 100 . " €",
                "<span class='bold'>Guarantie : </span>" . $article->getGuarDuration() . " mois",
                "?p=article&action=show&id=" . $article->getId()
            ];

            $displayTable[] = $table;
        }

        if(isset($displayTable))
            return $displayTable;
    }

}