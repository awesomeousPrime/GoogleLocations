<?php

/**
 * {@inheritdoc}
 */
class ArrayQueryService implements ArrayQueryInterface
{
    /** @var array property containing raw data array. */
    private $data = [];

    /**
     * Declares needed properties.
     */
    public function __construct($filePath)
    {
        if (!file_exists($filePath)) {

            throw new ArrayQueryException("The file '$filePath' was not found.");
        }

        $this->data = require $filePath;
    }

    /**
     * {@inheritdoc}
     */
    public function findBy($property, $value)
    {
        
    }
}