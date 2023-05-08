<?php

namespace App\Service;

use App\Data\CoordinatesData;

class LongitudeLatitudeService
{

    public function processMapApiResponse(array $apiResponse): CoordinatesData
    {
        $latitude = (float)$apiResponse['results'][0]['geometry']['location']['lat'];
        $longitude = (float)$apiResponse['results'][0]['geometry']['location']['lng'];
        return new CoordinatesData($longitude, $latitude);
    }
}
