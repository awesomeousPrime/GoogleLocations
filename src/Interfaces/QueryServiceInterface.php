<?php namespace Medology\GoogleLocations\Interfaces;

/**
 * Interface for making queries to data items.
 */
interface QueryServiceInterface {
    /**
     * Returns an object that matches both column and query.
     *
     * @param string $column This is the column that should be checked for value specified.
     * @param string $value  Value to check for on records.
     * @return array
     */
    public function getWhere($column, $value);
}
