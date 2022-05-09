<?php

namespace App\Entity;

class Action {
    
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $type;

    /**
     * @param integer $id
     * @param string $type
     */
    public function __construct(int $id, string $type)
    {
        $this->setId($id);
        $this->setType($type);
    }

    /**
     * @param integer $id
     * @return void
     */
    private function setId(int $id){
        if($id>=0) {
            $this->id = $id;
        }
    }
    /**
     * @param string $type
     * @return void
     */
    private function setType(string $type){
        if(strlen($type)<=20){
            $this->type = $type;
        }
    }
    
    /**
     *
     * @return integer
     */
    public function getId() : int {
        return $this->id;
    }

    /**
     *
     * @return string
     */
    public function getType() : string {
        return $this->type;
    }
    

}