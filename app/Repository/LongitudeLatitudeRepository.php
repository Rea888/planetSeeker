<?php

namespace App\Repository;

use App\Data\CoordinatesData;
use App\Service\LongitudeLatitudeService;
use Illuminate\Support\Facades\Http;

class LongitudeLatitudeRepository
{

    private LongitudeLatitudeService $longitudeLatitudeService;

    public function __construct(LongitudeLatitudeService $longitudeLatitudeService)
    {

        $this->longitudeLatitudeService = $longitudeLatitudeService;
    }

    public function getLatitudeAndLongitude(string $cityName): CoordinatesData
    {
        $get_data = Http::get('https://maps.googleapis.com/maps/api/geocode/json?address=' . $cityName . '&key=' . config('services.google.key'));
        $response = json_decode($get_data, true);
        return $this->longitudeLatitudeService->processMapApiResponse($response);

    }

}
