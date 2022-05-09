<?php

namespace App\Entity;

class Role {

    /**
     *
     * @var string
     */
    private $id;

    /**
     *
     * @var string
     */
    private $name;

    /**
     *
     * @param string $id
     * @param string $name
     */
    public function __construct(string $id, string $name)
    {
        $this->setId($id);
        $this->setName($name);
    }

    /**
     *
     * @param string $id
     * @return void
     */
    private function setId(string $id): void {
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
     * @return string
     */
    public function getId(): string { return $this->id; }

    /**
     *
     * @return string
     */
    public function getName(): string { return $this->name; }
}