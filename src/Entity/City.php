<?php

namespace App\Entity;

class City {

    /**
     * @var string
     */
    private $cog;

    /**
     * @var string
     */
    private $postCode;

    /**
     * @var string
     */
    private $name;

    /**
     * @param string $cog
     * @param string $postCode
     * @param string $name
     */
    public function __construct(string $cog, string $postCode, string $name) {
        $this->setCog($cog);
        $this->setPostCode($postCode);
        $this->setName($name);
    }

    /**
     *
     * @param string $cog
     * @return void
     */
    private function setCog(string $cog) {
        $this->cog = $cog;
    }

    /**
     *
     * @param string $postCode
     * @return void
     */
    private function setPostCode(string $postCode) {
            $this->postCode = $postCode;
    }

    /**
     *
     * @param string $name
     * @return void
     */
    private function setName(string $name) {
        $this->name = $name;
    }

    /**
     * 
     *
     * @return string
     */
    public function getCog() : string {
        return $this->cog;
    }
    
    /**
     * 
     *
     * @return string
     */
    public function getPostCode() : string {
        return $this->postCode;
    }

    /**
     * 
     *
     * @return string
     */
    public function getName() : string {
        return $this->name;
    }
}