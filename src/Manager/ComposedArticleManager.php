<?php

namespace App\Manager;

use App\Entity\Article;
use App\Entity\ComposedArticle;

class ComposedArticleManager extends AbstractManager
{

    public const TABLE = "composed";

    /**
     * Map each database row as object entity
     *
     * @param string $articleComposed
     * @param string $articleComposing
     * @param integer $quantity
     * @return ComposedArticle
     */
    public static function rowMapper(
        string $articleComposed,
        string $articleComposing,
        int $quantity
    ) : ComposedArticle {

        $article = ArticleManager::getOneBy(["articleID" => $articleComposing]);
        
        return new ComposedArticle(
            $article,
            $quantity
        );
    }
}