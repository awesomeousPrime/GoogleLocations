<?php namespace Medology\GoogleLocations\Services;

use Medology\GoogleLocations\Interfaces\QueryServiceInterface;

/**
 * Parent class for handling models.
 */
abstract class FinderService {
    /** @var  QueryServiceInterface */
    protected $queryService;

    public function __construct()
    {
        // We will retrieve our data from JSON files.
        $this->queryService = new JsonQueryService($this->getModelType());
    }

    /**
     * Returns a record with the column and value specified.
     *
     * @param string $column The column to search.
     * @param string $value  The value desired for the record to fin
     * @return array
     */
    public function getBy($column, $value)
    {
        $data = $this->queryService->getWhere($column, $value);

        return  end($data) ?: [];
    }

    /**
     * Returns the model type desired.
     *
     * @return string
     */
    abstract public function getModelType();
}
