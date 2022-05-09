<?php

namespace App\Manager;
use App\Entity\PurchaseArticle;
use App\Entity\Purchase;
use App\Entity\Article;

class PurchaseArticleManager extends AbstractManager {

    public const TABLE = "isaboutarticle";
 
    /**
     * Map each database row as object entity
     *
     * @param string $articleID
     * @param integer $purchaseID
     * @param integer $articleQty
     * @param integer $articleDelivQty
     * 
     * @return PurchaseArticle|null
     */
    public static function rowMapper(
        string $articleID, 
        int $purchaseID, 
        int $articleQty, 
        int $articleDelivQty

    ) : ?PurchaseArticle
    {
        $article = ArticleManager::getOneBy(["articleID" => $articleID]);
        
        return new PurchaseArticle(
            $article,
            $articleQty,
            $articleDelivQty
        );
    }

    /**
     * Insert a Database isaboutarticle from a php entity PurchaseArticle
     *
     * @param PurchaseArticle $purchaseArticle
     * @param Purchase $purchase
     * @return PurchaseArticle|null
     */
    public static function insert(PurchaseArticle $purchaseArticle,Purchase $purchase): ?PurchaseArticle {
        $str = "INSERT INTO " . self::TABLE . " (articleID,purchaseID,articleQty,articleDelivQty) VALUES 
        (:articleID,:purchaseID,:articleQty,:articleDelivQty);";
        $query= self::db()->prepare($str);
        $query->bindValue("articleID",$purchaseArticle->getArticle()->getId());
        $query->bindValue("purchaseID",$purchase->getId());
        $query->bindValue("articleQty",$purchaseArticle->getQuantity());
        $query->bindValue("articleDelivQty",$purchaseArticle->getDeliveredQuantity());
        $exec = $query->execute();
        if($exec) {
            self::disconnect();
            return $purchaseArticle;
        }
        self::disconnect();
        return null;
        
    }

    /**
     * Update a Database isaboutarticle from a php entity PurchaseArticle
     *
     * @param PurchaseArticle $purchaseArticle
     * @param Purchase $purchase
     * @return PurchaseArticle|null
     */
    public static function update(PurchaseArticle $purchaseArticle,Purchase $purchase): ?PurchaseArticle {
        $str = "UPDATE " . self::TABLE . " SET articleDelivQty = :articleDelivQty WHERE articleID=:articleID AND purchaseID = :purchaseID";
        $query = self::db()->prepare($str);
        $query->bindValue("articleDelivQty",$purchaseArticle->getDeliveredQuantity());
        $query->bindValue("articleID",$purchaseArticle->getArticle()->getId());
        $query->bindValue("purchaseID",$purchase->getId());
        $exec = $query->execute();

        if($exec) {
            self::disconnect();
            return $purchaseArticle;
        }
        self::disconnect();
        return null;
    }
}