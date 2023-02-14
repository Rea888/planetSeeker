<?php

namespace App\Service;

class LongitudeLatitudeService
{

    public function processMapApiResponse(array $apiResponse) :array
    {
        $latitude= $apiResponse['results'][0]['geometry']['location']['lat'];
        $longitude = $apiResponse['results'][0]['geometry']['location']['lng'];
        return array($latitude,$longitude);
    }
}
