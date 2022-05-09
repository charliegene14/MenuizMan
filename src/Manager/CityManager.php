<?php

namespace App\Manager;
use App\Entity\City;

class CityManager extends AbstractManager
{
    public const TABLE = "city";

    /**
     * Map each database row as object entity
     *
     * @param string $cog
     * @param string $postCode
     * @param string $cityName
     * @return City
     */
    public static function rowMapper(string $cog, string $postCode, string $cityName): City {
        return new City($cog, $postCode, $cityName);
    }

    /**
     *
     * @param array $attributes
     * @return City|null
     */
    public static function getOneBy(array $attributes): ?object {
        return parent::getOneBy($attributes);
    }

    /**
     * Insert a Database City from a php entity City
     *
     * @param City $city
     * @return City|null
     */
    public static function insert(City $city): ?City {
        
        $str = "INSERT INTO " . self::TABLE . " (COG, postCode, cityName) ";
        $str .= "VALUES (:cog, :postCode, :cityName)";
        $query = self::db()->prepare($str);

        $query->bindValue("cog", $city->getCog());
        $query->bindValue("postCode", $city->getPostCode());
        $query->bindValue("cityName", $city->getName());

        $exec = $query->execute();
        self::disconnect();

        if ($exec) {
            return $city;
        }
        return null;
    }
}