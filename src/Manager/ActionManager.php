<?php

namespace App\Manager;
use App\Entity\Action;

class ActionManager extends AbstractManager
{
    public const TABLE = "action";

    /**
     * Map each fetched rows according to the object entity arguments
     *
     * @param integer $id
     * @param string $type
     * @return Action
     */
    public static function rowMapper(int $id, string $type): Action {
        return new Action($id, $type);
    }

    /**
     * 
     * @param array $attributes
     * @return Action|null
     */
    public static function getOneBy(array $attributes): ?object {
        return parent::getOneBy($attributes);
    }
}