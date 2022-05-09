<?php

namespace App\Manager;

use App\Entity\Article;
use App\Exception\ManagerException;

class ArticleManager extends AbstractManager
{
    public const TABLE = "article";

    /**
     * Map each database row as object entity
     *
     * @param string $id
     * @param string $name
     * @param integer $price
     * @param integer|null $guarDuration
     * @param string|null $note1
     * @param string|null $note2
     * @return Article
     */
    public static function rowMapper(
        string $id,
        string $name,
        int $price,
        ?int $guarDuration = null,
        ?string $note1 = null,
        ?string $note2 = null

    ): Article {

        $article = new Article(
            $name,
            $price,
            $guarDuration,
            $note1,
            $note2,
            $id
        );

        $article->setComposition(
            ComposedArticleManager::getBy([
                "articleID_is_composed" => $id
            ])
        );

        $replacements = ReplaceManager::getBy([
            "articleID_is_replaced" => $id
        ]);

        $article->setReplacements($replacements);

        return $article;
    }

    /**
     *
     * @param array $attributes
     * @return Article|null
     */
    public static function getOneBy(array $attributes): ?object {
        return parent::getOneBy($attributes);
    }

    /**
     * Update a Database Article from a php entity Article
     *
     * @param Article $article
     * @return Article|null
     */
    public static function update(Article $article): ?Article {

        if (!$article->getId()) throw new ManagerException("Article must have an ID.");

        $dbReplacements = ReplaceManager::getBy([
            "articleID_is_replaced" => $article->getId()
        ]);

        /**
         * @var Article
         */
        foreach ($dbReplacements as $dbReplacement) {
            
            if (!in_array($dbReplacement, $article->getReplacements())) {
                // delete
                $test = ReplaceManager::deleteBy([
                    "articleID_is_replaced" =>  $article->getId(),
                    "articleID_is_replacing" => $dbReplacement->getId()
                ]);
            }
        }

        /**
         * @var Article
         */
        foreach ($article->getReplacements() as $replacement) {

            if (!in_array($replacement, $dbReplacements)) {
                // insert
                ReplaceManager::insert($article, $replacement);
            }
        }

        return $article;
    }
}