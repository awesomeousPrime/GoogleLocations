<?php

/**
 * Interface for service handling querying an array of arrays.
 */
interface LocationsQueryInterface
{
    /**
     * Searches each record present within the parent array and find and returns the child record with the specified
     * key and value.
     *
     * @param int $value
     * @return array
     */
    public function findByCriteriaId($value);
}