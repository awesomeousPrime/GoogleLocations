<?php namespace Medology\GeoLocations\Models;

/**
 * Different types of models that data can be retrieved from.
 *
 * This class will contain a constant with the value being the directory that the files for the model type exist.
 */
class ModelTypes {
    const GOOGLE_LOCATIONS = 'google_locations';
    const POSTAL_CODES = 'postal_codes';
}
