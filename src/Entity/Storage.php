<?php

namespace App\Entity;

class Storage {
    
    /**
     *
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var array<ComposedArticle>
     */
    private $articles = [];

    /**
     *
     * @param int $id
     * @param string $name
     * @param array<ComposedArticle> $articles
     */
    public function __construct(
        int $id,
        string $name
    )
    {
        $this->setId($id);
        $this->setName($name);
    }

    /**
     *
     * @param string $id
     * @return void
     */
    private function setId(int $id): void {
        $this->id = $id;
    }

    /**
     *
     * @param string $name
     * @return void
     */
    private function setName(string $name): void {
        $this->name = $name;
    }

    /**
     *
     * @param array<ComposedArticle> $articles
     * @return void
     */
    public function setArticles(array $articles): void {
        $this->articles = $articles;
    }

    /**
     * 
     *
     * @param Article $article
     * @param [type] $quantity
     * @return void
     */
    public function addArticle(Article $article, $quantity) {

        $alreadyExist = null;

        /**
         * @var ComposedArticle
         */
        foreach ($this->articles as $iArticle) {

            if ($iArticle->getArticle()->getId() === $article->getId()) {
                $iArticle->addQuantity($quantity);
                $alreadyExist = true;
                break;
            }
        }

        if(!$alreadyExist) {
            $this->articles[] = new ComposedArticle($article, $quantity);
        }

    }

    /**
     * 
     *
     * @param Article $article
     * @param [type] $quantity
     * @return void
     */
    public function removeArticle(Article $article, $quantity) {

        /**
         * @var ComposedArticle
         */
        foreach ($this->articles as $iArticle) {

            if ($iArticle->getArticle()->getId() === $article->getId()) {

                if($iArticle->getQuantity() - $quantity <= 0) {
                    $iArticle->setQuantity(0);
                } else {
                    $iArticle->removeQuantity($quantity);
                }
                break;
            }
        }
    }

    /**
     * 
     *
     * @return integer
     */
    public function getId(): int { return $this->id; }

    /**
     * 
     *
     * @return string
     */
    public function getName(): string { return $this->name; }

    /**
     * 
     *
     * @return array
     */
    public function getArticles(): array { return $this->articles; }
}