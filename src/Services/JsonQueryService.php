<?php namespace Medology\GeoLocations\Services;

use Medology\GeoLocations\Interfaces\QueryServiceInterface;

/**
 * Query service which handles running queries on json files.
 */
class JsonQueryService implements QueryServiceInterface {
    /** @var  string This is the directory that the json files are stored in. */
    protected $dir;

    /**
     * Will set up properties for instance.
     *
     * @param string $dataDir This is the directory where the json files are stored.
     */
    public function __construct($dataDir)
    {
        $this->dir = $dataDir;
    }

    /**
     * Returns an array of paths to the json files that will be used to retrieve information from.
     *
     * @return array
     */
    protected function getDataFilePaths()
    {
        $dataPath = $this->dir;
        $files = scandir($dataPath);
        $filePaths = [];

        foreach ($files as $file) {
            $filePath = $dataPath . '/' . $file;

            if (strpos($file, '.json') !== false) {
                $filePaths[] = $filePath;
            }
        }

        return $filePaths;
    }

    /**
     * Checks to see if an entry with matching column and value values exist in the file specified.
     *
     * @param string $path   Path to the file to check.
     * @param string $column Column value to search for.
     * @param string $value  Record value expected.
     * @return bool
     */
    protected function existsInDataFile($path, $column, $value)
    {
        $contents = file_get_contents($path);
        $search = '"' . $column . '":"' . $value . '"';

        return (strpos($contents, $search) !== false) ? true : false;
    }

    /**
     * {@inheritdoc}
     */
    public function getWhere($column, $value)
    {
        $filePaths = $this->getDataFilePaths();
        $foundFilePath = '';

        foreach ($filePaths as $filePath) {
            if ($this->existsInDataFile($filePath, $column, $value)) {
                $foundFilePath = $filePath;
                break;
            }
        }

        // If nothing was found return false.
        if ($foundFilePath == '') {
            return [];
        }

        $dataJson = file_get_contents($foundFilePath);
        $dataArray = json_decode($dataJson, true);

        return array_filter($dataArray, function ($location) use ($column, $value) {
            if ($location[$column] == $value) {

                return $location;
            }
        }) ?: [];
    }
}
