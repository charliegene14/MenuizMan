<?php

namespace App\Entity;

class PurchaseArticle extends ComposedArticle
{

    /**
     * @var int
     */
    private $deliveredQuantity;


    /**
     *
     * @param Article $article
     * @param integer $quantity
     * @param integer $deliveredQuantity
     */
    public function __construct(
        Article $article,
        int $quantity,
        int $deliveredQuantity
    )
    {
        parent::__construct($article, $quantity);
        $this->setDeliveredQuantity($deliveredQuantity);
    }

    /**
     *
     * @param integer $deliveredQuantity
     * @return void
     */
    private function setDeliveredQuantity(int $deliveredQuantity): void {
        $this->deliveredQuantity = $deliveredQuantity;
    }

    /**
     * 
     *
     * @return integer
     */
    public function getDeliveredQuantity(): int { return $this->deliveredQuantity; }

    /**
     * 
     *
     * @return integer
     */
    public function getTotalPrice(): int {

        return parent::getArticle()->getPrice() * parent::getQuantity();
    }
 
}