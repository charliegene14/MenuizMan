<?php

namespace App\Manager;

use App\Entity\Article;

class ReplaceManager extends AbstractManager
{
    public const TABLE = "canreplace";

    /**
     * Map each database row as object entity
     *
     * @param string $parent
     * @param string $child
     * @return void
     */
    public static function rowMapper(
        string $parent,
        string $child
    )
    {
        
        return ArticleManager::getOneBy(["articleID" => $child]);
    }

    /**
     * Insert a Database canreplace from two php entities Article
     *
     * @param Article $parent
     * @param Article $child
     * @return Article|null
     */
    public static function insert(Article $parent, Article $child): ?Article {

        $str = "INSERT INTO " . self::TABLE . " (articleID_is_replaced, articleID_is_replacing) ";
        $str .= "VALUES (:parent, :child)";

        $query = self::db()->prepare($str);

        $query->bindValue("parent", $parent->getId());
        $query->bindValue("child", $child->getId());

        $exec = $query->execute();
        self::disconnect();

        if ($exec) {
            return $child;
        }

        return null;
    }

}