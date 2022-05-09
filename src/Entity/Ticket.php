<?php

namespace App\Entity;
use DateTime;

class Ticket {

    /**
     * @var int
     */
    private $id;

    /**
     * @var TicketType
     */
    private $type;

    /**
     * @var Article|null
     */
    private $article;

    /**
     * @var array<UserAction>
     */
    private $actions = [];

    /**
     * @var Purchase
     */
    private $purchase;

    /**
     * @var string|null
     */
    private $commentary;

    /**
     * @var bool
     */
    private $isClosed;

    /**
     * @var bool
     */
    private $isUrgent;

    /**
     * @var int|null
     */
    private $treatedQty;

    /**
     *
     * @param TicketType $type
     * @param Purchase $purchase
     * @param integer|null $fileNumber Auto increment according to the max file number in db
     * @param boolean $isClosed
     * @param boolean $isUrgent
     * @param Article|null $article
     * @param integer|null $treatedQty
     * @param string|null $commentary
     * @param array $actions
     * @param integer|null $id Auto increment in db
     */
    public function __construct(
        TicketType $type,
        Purchase $purchase,
        bool $isClosed = false,
        bool $isUrgent = false,
        ?Article $article = null,
        ?int $treatedQty = null,
        ?string $commentary = null,
        ?int $id = null
    )
    {
        $this->setID($id);
        $this->setPurchase($purchase);
        $this->setTicketType($type);
        $this->setIsClosed($isClosed);
        $this->setIsUrgent($isUrgent);
        $this->setArticle($article);
        $this->setTreatedQty($treatedQty);
        $this->setCommentary($commentary);
    
    }

    /**
     * 
     *
     * @param integer|null $id
     * @return void
     */
    private function setID(?int $id = null) {
        $this->id = $id;
    }

    /**
     * 
     *
     * @param Purchase $purchase
     * @return void
     */
    private function setPurchase(Purchase $purchase) {
        $this->purchase = $purchase;
    }

    /**
     * 
     *
     * @param TicketType $type
     * @return void
     */
    private function setTicketType(TicketType $type) {
        $this->type = $type;
    }

    /**
     *
     * @param array<UserAction> $actions
     * @return void
     */
    public function setActions(array $actions) {
        $this->actions = $actions;
    }

    /**
     * 
     *
     * @param boolean $isClosed
     * @return void
     */
    public function setIsClosed(bool $isClosed = false) {
        $this->isClosed = $isClosed;
    }

    /**
     * 
     *
     * @param boolean $isUrgent
     * @return void
     */
    public function setIsUrgent(bool $isUrgent = false) {
        $this->isUrgent = $isUrgent;
    }

    /**
     * 
     *
     * @param Article|null $article
     * @return void
     */
    private function setArticle(?Article $article = null) {
        $this->article = $article;
    }


    /**
     * 
     *
     * @param integer|null $treatedQty
     * @return void
     */
    private function setTreatedQty(?int $treatedQty = null) {
        $this->treatedQty = $treatedQty;
    }

    /**
     * 
     *
     * @param string|null $commentary
     * @return void
     */
    private function setCommentary (?string $commentary = null) {
        $this->commentary = $commentary;
    }


    /**
     * 
     *
     * @return integer|null
     */
    public function getId(): ?int { return $this->id; }

    /**
     * 
     *
     * @return TicketType
     */
    public function getType(): TicketType { return $this->type; }

    /**
     * 
     *
     * @return Article|null
     */
    public function getArticle(): ?Article { return $this->article; }

    /**
     * 
     *
     * @return array
     */
    public function getActions(): array { return $this->actions; }

    /**
     * 
     *
     * @return Purchase
     */
    public function getPurchase(): Purchase { return $this->purchase; }

    /**
     * 
     *
     * @return string|null
     */
    public function getCommentary(): ?string { return $this->commentary; }

    /**
     * 
     *
     * @return boolean
     */
    public function isClosed(): bool { return $this->isClosed; }

    /**
     * 
     *
     * @return boolean
     */
    public function isUrgent(): bool { return $this->isUrgent; }

    /**
     * 
     *
     * @return integer|null
     */
    public function getTreatedQty(): ?int { return $this->treatedQty; }

    /**
     *
     * @param UserAction $action
     * @return void
     */
    public function addAction(UserAction $action): void {
        $this->actions[] = $action;
    }

    /**
     * 
     *
     * @return UserAction|null
     */
    public function getLastAction(): ?UserAction {
        
        if (!empty($this->actions)) {
            return $this->actions[count($this->actions) - 1];
        } else {
            return NULL;
        }
    }
}