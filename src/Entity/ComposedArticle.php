<?php

namespace App\Entity;

class ComposedArticle
{
    
    /**
     *
     * @var Article
     */
    private $article;

    /**
     *
     * @var int
     */
    protected $quantity;

    /**
     *
     * @param Article $article
     * @param integer $quantity
     */
    public function __construct(Article $article, int $quantity)
    {
        $this->setArticle($article);
        $this->setQuantity($quantity);
    }

    /**
     *
     * @param Article $article
     * @return void
     */
    private function setArticle(Article $article): void {
        $this->article = $article;
    }

    /**
     *
     * @param integer $quantity
     * @return void
     */
    public function setQuantity(int $quantity): void {
        $this->quantity = $quantity;
    }

    /**
     * 
     *
     * @param integer $quantity
     * @return void
     */
    public function addQuantity(int $quantity): void {
        $this->quantity += $quantity;
    }

    /**
     * 
     *
     * @param integer $quantity
     * @return void
     */
    public function removeQuantity(int $quantity): void {
        $this->quantity -= $quantity;
    }

    /**
     * 
     *
     * @return Article
     */
    public function getArticle(): Article { return $this->article; }

    /**
     * 
     *
     * @return integer
     */
    public function getQuantity(): int { return $this->quantity; }
}