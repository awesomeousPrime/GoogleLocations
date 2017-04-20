<?php

/**
 * {@inheritdoc}
 */
class LocationsQueryService implements LocationsQueryInterface
{
    // This is the name of the criteria index file.
    const CRITERIA_INDEX_FILE = 'criteria_id.json';

    /**
     * {@inheritdoc}
     */
    public function findByCriteriaId($value)
    {

        return $this->findByCriteriaIdWithIndexing($value) ?: $this->findByCriteriaIdWithoutIndexing($value);
    }

    /**
     * @todo possibly implement this.
     *
     * @param $criteriaId
     * @return bool
     */
    protected function findByCriteriaIdWithIndexing($criteriaId)
    {

        return false;
//        $file = $this->findFileById($this->findIdByCriteriaId($value));
//        $fileContentsArray = json_decode(file_get_contents(__DIR__ . '/../../data/indexes/' . $file), true);
//
//        return array_filter($fileContentsArray, function ($location) use ($value) {
//            if ($location['criteria_id'] == $value) {
//
//                return $location;
//            }
//        });
    }

    /**
     * @param $criteriaId
     * @return array|mixed
     */
    protected function findByCriteriaIdWithoutIndexing($criteriaId)
    {
        $dataFiles = [
            'google_locations1',
            'google_locations2',
            'google_locations2',
            'google_locations3',
            'google_locations4',
        ];

        $searchString = '"criteria_id":"' . $criteriaId . '"';

        foreach ($dataFiles as $file) {
            $contents = file_get_contents(__DIR__ . '/../../data/indexes/' . $file . '.json');

            if (strpos($contents, $searchString) === false) {
                continue;
            }

            $dataArray = json_decode($contents, true);

            $found = array_filter($dataArray, function ($location) use ($criteriaId) {
                if ($location['criteria_id'] == $criteriaId) {

                    return $location;
                }
            });

            if ($found) {

                return $found;
            }
        }

        return false;
    }
    
    /**
     * Uses index file to search for record ID based on the criteria id.
     *
     * @param int $criteriaId This is the criteria id to search for.
     * @return int
     * @throws Exception If the index file was not found or the value specified was not found in the index
     * file.
     */
    protected function findIdByCriteriaId($criteriaId)
    {
        $indexArray = json_decode(self::getIdIndexContents(), true);

        if (!array_key_exists($criteriaId, $indexArray)) {
            throw new Exception("Index for criteria id value of '$criteriaId' was not found.");
        }

        return $indexArray[$criteriaId];
    }

    /**
     *
     */
    protected function findFileById($id)
    {
        $pageIndexFiles = self::getFileIndexes();

        foreach ($pageIndexFiles as $file => $value) {
            if ($id >= $value['min'] && $id <= $value['max']) {
                return $file;
            }
        }
    }

    /**
     * @return mixed
     */
    public static function getFileIndexes()
    {
        return require __DIR__ . '/../../file.php';
    }

    /**
     *
     */
    public static function getIdIndexContents()
    {
        $indexPath = __DIR__ . '/../../indexes.json';
        // Index file will be required since otherwise, the server may crash.
        if (!file_exists($indexPath)) {
            throw new Exception("The following index file was not found '{$indexPath}'");
        }

        return file_get_contents($indexPath);
    }
}
