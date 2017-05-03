<?php namespace Medology\GeoLocations\Services;

use Medology\GeoLocations\Interfaces\QueryServiceInterface;

/**
 * Parent class for handling models.
 */
abstract class FinderService {
    /** @var  QueryServiceInterface */
    protected $queryService;

    public function __construct()
    {
        // We will retrieve our data from JSON files.
        $this->queryService = new JsonQueryService($this->getFilePath());
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
     * Returns the full path from where to read data from.
     *
     * @return string
     */
    abstract public function getFilePath();
}
