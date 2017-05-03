<?php namespace Medology\GeoLocations\Services;

use Medology\GeoLocations\Models\ModelTypes;

/**
 * Object to handle google location records.
 */
class GoogleLocationsFinder extends FinderService {
    /**
     * {@inheritdoc}
     */
    public function getFilePath()
    {
        return __DIR__ . '/../../data/' . ModelTypes::GOOGLE_LOCATIONS;
    }
}