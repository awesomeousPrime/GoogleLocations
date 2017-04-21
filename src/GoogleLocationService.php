<?php namespace Medology\GoogleLocations;

use Medology\GoogleLocations\Models\GoogleLocations;
use Medology\GoogleLocations\Models\Model;
use Medology\GoogleLocations\Models\ZipCodes;

/**
 * Service for returning a location from the google locations data file.
 */
class GoogleLocationService{
    /** @var  Model */
    private $googleLocationFinder;

    /** @var  Model */
    private $zipCodeFinder;

    /**
     * GoogleLocationService constructor.
     */
    public function __construct()
    {
        // Use the same services within the class.
        $this->googleLocationFinder = new GoogleLocations();
        $this->zipCodeFinder = new ZipCodes();
    }

    /**
     * Returns the display name based on the interest id, physical id, and campaign id.
     *
     * @param int $interestId
     * @param int $physicalId
     * @param int $campaignId
     * @return string
     */
    public function getDisplayName($interestId, $physicalId, $campaignId)
    {
        $locationName = '';
        $location = '';

        // If an interest ID exists, attempt to get google location from this.
        if ($interestId) {
            $location = $this->googleLocationFinder->getBy('criteria_id', $interestId);
        }

        // If no google location was found and a physicalId exists attempt to get google location based on physical
        // ID.
        if (!$location && $physicalId) {
            $location = $this->googleLocationFinder->getBy('criteria_id', $physicalId);
        }

        if ($location) {
            if ($location['target_type'] != 'Postal Code') {
                $locationName = $location['short_name'];
            } else {
                // Since the target_type is a Postal Code, the short_name is a postal code value.
                $zipCodeRecord = $this->zipCodeFinder->getBy('zip_code', $location['short_name']);

                // If a zip_codes record is found, the city name will be used as the location name.
                if ($zipCodeRecord) {
                    $locationName = $zipCodeRecord['city'];
                }
            }
        }

        // If no location name has been found still, attempt the campaign id.
        if (!$locationName && $campaignId) {
            $locationName = $campaignId;
        }

        return ucwords($locationName);
    }
}
