<?php

/**
 * Service for returning a location from the google locations data file.
 */
class GoogleLocationService{
    /** @var  ArrayQueryInterface */
    private $arrayQueryService;

    /**
     * GoogleLocationService constructor.
     */
    public function __construct()
    {
        $this->arrayQueryService = new LocationsQueryService();
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
            $location = $this->arrayQueryService->findBy('criteria_id', $interestId);
        }

        // If no google location was found and a physicalId exists attempt to get google location based on physical
        // ID.
        if (!$location && $physicalId) {
            $location = $this->arrayQueryService->findBy('criteria_id', $physicalId);
        }

        if ($location) {
            if ($location['target_type'] != 'Postal Code') {
                $locationName = $location['short_name'];
            } else {
                // Since the target_type is a Postal Code, the short_name is a postal code value.
                $zipCodeRecord = $location['zipCode'];

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
