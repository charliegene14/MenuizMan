<?php

namespace App\Entity;

class Article {
    
     /**
     * @var string
     */
    private $id;

     /**
     * @var string
     */
    private $name;

     /**
     * @var int
     */
    private $price;

     /**
     * @var int|null
     */
    private $guarDuration;

     /**
     * @var string|null
     */
    private $note1;

     /**
     * @var string|null
     */
    private $note2;

    /**
     *
     * @var array<ComposedArticle>
     */
    private $composition = [];

    /**
     *
     * @var array<Article>
     */
    private $replacements = [];

    /**
     *
     * @param string $id
     * @param string $name
     * @param int $price
     * @param integer|null $guarDuration
     * @param string|null $note2
     * @param string|null $note2
     */
    public function __construct(
        string $name,
        int $price,
        int $guarDuration = null,
        string $note1 = null,
        string $note2 = null,
        string $id = null
    )
    {
        $this->setId($id);
        $this->setName($name);
        $this->setPrice($price);
        $this->setGuarDuration($guarDuration);
        $this->setNote1($note1);
        $this->setNote2($note2);
    }

    /**
     *
     * @param integer $id
     * @return void
     */
    private function setId(string $id) {
        $this->id = $id;
    }

    /**
     *
     * @param string $name
     * @return void
     */
    private function setName(string $name) {
        if (strlen($name)<=75){
            $this->name = $name;
        }
    }

    /**
     *
     * @param int $price
     * @return void
     */
    private function setPrice(int $price) {
        if($price >= 0) {
            $this->price = $price;
        }
    }

    /**
     *
     * @param integer $guarDuration
     * @return void
     */
    private function setGuarDuration(?int $guarDuration = null) {
        $this->guarDuration = $guarDuration;
    }

    /**
     *
     * @param string $note1
     * @return void
     */
    private function setNote1(?string $note1 = null) {
        $this->note1 = $note1;
    
    }

    /**
     *
     * @param string $note2
     * @return void
     */
    private function setNote2(?string $note2 = null) {
        $this->note2 = $note2;
    }
    
    /**
     *
     * @return string
     */
    public function getId() : string {
        return $this->id;
    }

    /**
     * 
     *
     * @return string
     */
    public function getName() : string {
        return $this->name;
    }

    /**
     * 
     *
     * @return integer
     */
    public function getPrice() : int {
        return $this->price;
    }

    /**
     * 
     *
     * @return integer|null
     */
    public function getGuarDuration() : ?int {
        return $this->guarDuration;
    }

    /**
     * 
     *
     * @param integer $note
     * @return string|null
     */
    public function getNote(int $note) : ?string {
        
        return $note === 1 ? $this->note1 : $this->note2;
    }

    /**
     *
     * @param array<ComposedArticle> $composition
     * @return void
     */
    public function setComposition(array $composition): void {
        $this->composition = $composition;
    }

    /**
     *
     * @param array<Article> $replacements
     * @return void
     */
    public function setReplacements(array $replacements): void {
        $this->replacements = $replacements;
    }

    /**
     *
     * @param Article $replacement
     * @return void
     */
    public function addReplacement(Article $replacement) {

        $alreadyExist = null;

        /**
         * @var Article
         */
        foreach ($this->replacements as $iReplace) {
            if ($iReplace->getId() === $replacement->getId()) {
                $alreadyExist = true;
                break;
            }
        }

        if(!$alreadyExist) {
            $this->replacements[] = $replacement;
        }
    }

    /**
     *
     * @param Article $article
     * @param integer $quantity
     * @return void
     */
    public function addComposition(Article $article, int $quantity) {

        $alreadyExist = null;

        /**
         * @var ComposedArticle
         */
        foreach ($this->composition as $iCompo) {
            if ($iCompo->getArticle()->getId() === $article->getId()) {
                $iCompo->addQuantity($quantity);
                $alreadyExist = true;
                break;
            }
        }

        if(!$alreadyExist) {
            $this->composition[] = new ComposedArticle($article, $quantity);
        }
    }

    /**
     * Undocumented function
     *
     * @param Article $replacement
     * @return void
     */
    public function removeReplacement(Article $replacement) {

        foreach ($this->replacements as $iReplace) {
            if ($iReplace->getId() === $replacement->getId()) {

                $i = array_search($iReplace, $this->replacements);
                
                array_splice($this->replacements, $i, $i+1);
                //$this->replacements[$i] = null;
            }
        }
    }

    /**
     *
     * @param Article $article
     * @param integer $quantity
     * @return void
     */
    public function removeComposition(Article $article, int $quantity) {

        /**
         * @var ComposedArticle
         */
        foreach ($this->composition as $iArticle) {

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

    public function getComposition(): array { return $this->composition; }
    public function getReplacements(): array { return $this->replacements; }
}