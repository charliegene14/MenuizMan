<?php

namespace App\Manager;

use App\Entity\ComposedArticle;
use App\Entity\Storage;
use App\Exception\ManagerException;

class StorageManager extends AbstractManager
{

    public const TABLE = "storage";

    /**
     * Map each database row as object entity
     *
     * @param integer $id
     * @param string $name
     * @return Storage
     */
    public static function rowMapper(int $id, string $name):Storage {

        $storage = new Storage(
            $id,
            $name
        );
        
        $articles = StoredArticleManager::getBy([
            "storageID" => $id
        ]);

        $storage->setArticles($articles);

        return $storage;
    }

    /**
     * Update a Database storage from a php entity Storage
     * 
     * @param Storage $user
     * @return Storage|null
     */
    public static function update(Storage $storage): ?Storage {

        if (!$storage->getId()) throw new ManagerException("Storage must have an ID.");

        $str = "UPDATE " . self::TABLE . " SET ";
        $str .= "storageType = :storageType";
        $str .= " WHERE storageID = :storageID";

        $query = self::db()->prepare($str);

        $query->bindValue("storageID", $storage->getId());
        $query->bindValue("storageType", $storage->getName());

        $exec = $query->execute();

        /**
         * @var ComposedArticle
         */
        foreach($storage->getArticles() as $article) {

            $dbHasArticle = StoredArticleManager::getOneBy([
                "articleID" => $article->getArticle()->getId(),
                "storageID" => $storage->getId()
            ]);

            if ($dbHasArticle) {

                if ($article->getQuantity() === 0) {
    
                    StoredArticleManager::deleteBy([
                        "articleID" => $article->getArticle()->getId(),
                        "storageID" => $storage->getId()
                    ]);
    
                } else {

                    StoredArticleManager::update($article, $storage);
                }

            } else {
                StoredArticleManager::insert($article, $storage);
            }
            
        }

        if ($exec) {

            self::disconnect();
            return $storage;
        }

        self::disconnect();
        return null;
    }

    /**
     *
     * @param array $attributes
     * @return Storage|null
     */
    public static function getOneBy(array $attributes): ?object {
        return parent::getOneBy($attributes);
    }

}