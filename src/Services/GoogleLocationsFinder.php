<?php namespace Medology\GoogleLocations\Services;

use Medology\GoogleLocations\Models\ModelTypes;

/**
 * Object to handle google location records.
 */
class GoogleLocationsFinder extends FinderService {
    /**
     * {@inheritdoc}
     */
    public function getModelType()
    {
        return ModelTypes::GOOGLE_LOCATIONS;
    }
}