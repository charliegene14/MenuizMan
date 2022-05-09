<?php

namespace App\Manager;
use App\Entity\TicketType;
use App\Manager\TicketManager;
class TicketTypeManager extends AbstractManager
{
    public const TABLE = "tickettype";

    /**
     * Map each database row as object entity
     *
     * @param string $id
     * @param string $name
     * @return TicketType
     */
    public static function rowMapper(string $id, string $name): TicketType {
        return new TicketType($id, $name);
    }

    /**
     *
     * @param array $attributes
     * @return TicketType|null
     */
    public static function getOneBy(array $attributes): ?object {
        return parent::getOneBy($attributes);
    }

}