<?php namespace Medology\GoogleLocations\Services;

use Medology\GoogleLocations\Models\ModelTypes;

/**
 * Object to handle zip code records.
 */
class ZipCodesFinder extends FinderService {
    /**
     * {@inheritdoc}
     */
    public function getModelType()
    {
        return ModelTypes::ZIP_CODES;
    }
}
