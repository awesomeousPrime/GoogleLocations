<?php

/**
 * Interface for service handling querying an array of arrays.
 */
interface ArrayQueryInterface
{
    /**
     * Searches each record present within the parent array and find and returns the child record with the specified
     * key and value.
     *
     * @return array
     */
    public function findBy($property, $value);
}