<?php

namespace App\Entity;
use App\Entity\User;
use App\Entity\Action;
use DateTime;

class UserAction {

    /**
     *
     * @var int|null
     */
    private $id;

    /**
     *
     * @var User
     */
    private $user;

    /**
     *
     * @var Action
     */
    private $action;

    /**
     *
     * @var DateTime|null
     */
    private $datetimeStart;

    /**
     *
     * @var DateTime|null
     */
    private $datetimeEnd;

    /**
     *
     * @param User $user
     * @param Action $action
     * @param boolean $isTodo
     * @param DateTime|null $datetimeStart
     * @param string|null $commentary
     */
    public function __construct(
        Action $action,
        ?User $user = null,
        ?DateTime $datetimeStart = null,
        ?DateTime $datetimeEnd = null,
        ?string $commentary = null,
        ?int $id = null
    )
    {
        $this->setId($id);
        $this->setUser($user);
        $this->setAction($action);
        $this->setDatetimeStart($datetimeStart);
        $this->setDatetimeEnd($datetimeEnd);
        $this->setCommentary($commentary);
    }

    /**
     *
     * @param integer|null $id
     * @return void
     */
    private function setId(?int $id = null) {
        $this->id = $id;
    }

    /**
     *
     * @param User $user
     * @return void
     */
    public function setUser(?User $user = null) {
        $this->user = $user;
    }

    /**
     *
     * @param Action $action
     * @return void
     */
    public function setAction(Action $action) {
        $this->action = $action;
    }

    /**
     *
     * @param DateTime $datetimeStart
     * @return void
     */
    public function setDatetimeStart(?DateTime $datetimeStart = null) {
        $this->datetimeStart = $datetimeStart;
    }

    /**
     *
     * @param DateTime|null $datetimeEnd
     * @return void
     */
    public function setDatetimeEnd(?DateTime $datetimeEnd = null) {
        $this->datetimeEnd = $datetimeEnd;
    }

    /**
     * 
     *
     * @param string|null $commentary
     * @return void
     */
    public function setCommentary(?string $commentary = null) {
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
     * @return User|null
     */
    public function getUser(): ?User { return $this->user; }

    /**
     * 
     *
     * @return Action
     */
    public function getAction(): Action { return $this->action; }

    /**
     * 
     *
     * @return DateTime|null
     */
    public function getStart(): ?DateTime { return $this->datetimeStart; }

    /**
     * 
     *
     * @return DateTime|null
     */
    public function getEnd(): ?DateTime { return $this->datetimeEnd; }

    /**
     * 
     *
     * @return string|null
     */
    public function getCommentary() : ?string { return $this->commentary; }

    /**
     * 
     *
     * @return boolean
     */
    public function isTodo(): bool {
        
        if (!$this->datetimeStart || !$this->user)
            return true;
        return false;
    }

    /**
     * 
     *
     * @return boolean
     */
    public function onDoing(): bool {

        if ($this->datetimeStart && !$this->datetimeEnd)
            return true;
        return false;
    }

    /**
     * 
     *
     * @return boolean
     */
    public function isDone(): bool {

        if ($this->datetimeStart && $this->datetimeEnd)
            return true;
        return false;
    }
}