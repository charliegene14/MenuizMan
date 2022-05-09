<?php

namespace App\Manager;

use App\Entity\Role;

class RoleManager extends AbstractManager {

    public const TABLE = "role";

    /**
     * Map each database row as object entity
     *
     * @param string $id
     * @param string $name
     * @return Role
     */
    public static function rowMapper(string $id, string $name): Role {
        return new Role($id, $name);
    }

    /**
     *
     * @param array $attributes
     * @return Role|null
     */
    public static function getOneBy(array $attributes): ?object {
        return parent::getOneBy($attributes);
    }
}