<?php

namespace App\Entity;
use DateTime;

class Purchase {
    
    /**
     * @var int
     */
    private $id;

    /**
     * @var Customer
     */
    private $customer;

    /**
     * @var array<PurchaseArticle>
     */
    private $articles = [];

    /**
     * @var array<Ticket>
     */
    private $tickets = [];

    /**
     *
     * @var bool
     */
    private $paymentStatus;

    /**
     * @var DateTime
     */
    private $date;

    /**
     * @var int
     */
    private $invoice;

    /**
     *
     * @param integer $id
     * @param Customer $customer
     * @param array $articles
     * @param boolean $paymentStatus
     * @param integer $invoice
     * @param DateTime|null $date
     * @param array $tickets
     */
    public function __construct(
        int $id,
        Customer $customer,
        array $articles,
        bool $paymentStatus,
        int $invoice,
        DateTime $date = null,
        array $tickets = []
    )
    {
        $this->setId($id);
        $this->setCustomer($customer);
        $this->setArticles($articles);
        $this->setPaymentStatus($paymentStatus);
        $this->setInvoice($invoice);
        $this->setDate($date);
        $this->setTickets($tickets);
    }


    /**
     * Set the value of id
     *
     * @param  int  $id
     */ 
    private function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * Set the value of customer
     *
     * @param  Customer  $customer
     */ 
    private function setCustomer(Customer $customer)
    {
        $this->customer = $customer;
    }

    /**
     * Set the value of articles
     *
     * @param  array<PurchaseArticle>  $articles
     */ 
    private function setArticles(array $articles)
    {
        $this->articles = $articles;
    }

    /**
     * Set the value of tickets
     *
     * @param  array<Ticket>  $tickets
     */ 
    public function setTickets(array $tickets)
    {
        $this->tickets = $tickets;
    }

    /**
     * Set the value of paymentStatus
     *
     * @param  bool  $paymentStatus
     * 
     */ 
    private function setPaymentStatus(bool $paymentStatus)
    {
        $this->paymentStatus = $paymentStatus;
    }

    /**
     * Set the value of date
     *
     * @param  DateTime  $date
     */ 
    private function setDate(?DateTime $date = null)
    {
        if ($date === null) $this->date = new DateTime();
        else $this->date = $date;
    }

    /**
     * Set the value of invoice
     *
     * @param  int  $invoice
     */ 
    private function setInvoice(int $invoice)
    {
        $this->invoice = $invoice;
    }

    /**
     * Get the value of id
     *
     * @return  int
     */ 
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Get the value of customer
     *
     * @return  Customer
     */ 
    public function getCustomer(): Customer
    {
        return $this->customer;
    }

    /**
     * Get the value of articles
     *
     * @return  array<PurchaseArticle>
     */ 
    public function getArticles(): array
    {
        return $this->articles;
    }

    /**
     * Get the value of tickets
     *
     * @return  array<Ticket>
     */ 
    public function getTickets(): array
    {
        return $this->tickets;
    }

    /**
     * Get the value of paymentStatus
     *
     * @return  bool
     */ 
    public function getPaymentStatus(): bool
    {
        return $this->paymentStatus;
    }

    /**
     * Get the value of date
     *
     * @return  DateTime
     */ 
    public function getDate(): DateTime
    {
        return $this->date;
    }

    /**
     * Get the value of invoice
     *
     * @return  int
     */ 
    public function getInvoice(): int
    {
        return $this->invoice;
    }

    /**
     * Get the total price of the purchase
     *
     * @return integer
     */
    public function getTotalPrice(): int {

        $total = 0;

        /**
         * @var PurchaseArticle
         */
        foreach ($this->articles as $pArticle) {

            $total += $pArticle->getTotalPrice();
        }

        return $total;
    }

}