<?php namespace Medology\GeoLocations\Services;

use Medology\GeoLocations\Models\ModelTypes;

/**
 * Object to handle zip code records.
 */
class ZipCodesFinder extends FinderService {
    /**
     * {@inheritdoc}
     */
    public function getFilePath()
    {
        return __DIR__ . '/../../data/' . ModelTypes::ZIP_CODES;
    }
}
