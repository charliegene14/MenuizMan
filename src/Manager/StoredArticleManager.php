<?php

namespace App\Manager;

use App\Entity\Storage;
use App\Entity\ComposedArticle;

class StoredArticleManager extends AbstractManager
{

    public const TABLE = "stocked";

    /**
     * Map each database row as object entity
     * 
     * @param string $articleID
     * @param integer $storageID
     * @param integer $quantity
     * @return void
     */
    public static function rowMapper(
        string $articleID,
        int $storageID,
        int $quantity
    )
    {

        return new ComposedArticle(
            ArticleManager::getOneBy(["articleID" => $articleID]),
            $quantity
        );
    }

    /**
     * Insert a Database stocked from php entities ComposedArticle and Storage
     *
     * @param ComposedArticle $article
     * @param Storage $storage
     * @return ComposedArticle|null
     */
    public static function insert(ComposedArticle $article, Storage $storage): ?ComposedArticle {
        
        $str = "INSERT INTO " . self::TABLE . " (articleID, storageID, storagedQty) ";
        $str .= "VALUES (:articleID, :storageID, :storagedQty)";
        $query = self::db()->prepare($str);

        $query->bindValue("articleID", $article->getArticle()->getId());
        $query->bindValue("storageID", $storage->getId());
        $query->bindValue("storagedQty", $article->getQuantity());

        $exec = $query->execute();
        self::disconnect();

        if ($exec) {
            return $article;
        }
        return null;
    }

    /**
     * Update a Database stocked from php entities ComposedArticle and Storage
     *
     * @param ComposedArticle $user
     * @return ComposedArticle|null
     */
    public static function update(ComposedArticle $article, Storage $storage): ?ComposedArticle {

        $quantity = $article->getQuantity();

        $str = "UPDATE " . self::TABLE . " SET ";
        $str .= "storagedQty = :storagedQty";
        $str .= " WHERE storageID = :storageID AND articleID = :articleID";

        $query = self::db()->prepare($str);

        $query->bindValue("storagedQty", $quantity);
        $query->bindValue("storageID", $storage->getId());
        $query->bindValue("articleID", $article->getArticle()->getId());

        $exec = $query->execute();
        self::disconnect();

        if ($exec) {
            return $article;
        }

        return null;
    }

    /**
     *
     * @param array $attributes
     * @return ComposedArticle|null
     */
    public static function getOneBy(array $attributes): ?object {
        return parent::getOneBy($attributes);
    }
}