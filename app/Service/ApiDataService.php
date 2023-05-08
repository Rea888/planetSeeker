<?php

namespace App\Service;

use App\Models\HistoricalHumidityProcessingReportsModel;
use App\Models\HistoricalWeatherHumidityModel;
use App\Repository\LongitudeLatitudeRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class ApiDataService
{

    private LongitudeLatitudeRepository $longitudeLatitudeRepository;

    public function __construct(LongitudeLatitudeRepository $longitudeLatitudeRepository)
    {
        $this->longitudeLatitudeRepository = $longitudeLatitudeRepository;
    }

    public function getParametersFromApi($cityName, $year, $month, $parameter): array
    {
        $latitudeAndLongitude = $this->longitudeLatitudeRepository->getLatitudeAndLongitude($cityName);
        $latitude = $latitudeAndLongitude->getLatitude();
        $longitude = $latitudeAndLongitude->getLongitude();

        $startDate = $year . '-' . $month . '-01';
        $endDate = date("Y-m-t", strtotime($startDate));

        $apiResponse = Http::get(sprintf("https://archive-api.open-meteo.com/v1/archive?latitude=%s&longitude=%s&start_date=%s&end_date=%s&hourly=%s", $latitude, $longitude, $startDate, $endDate, $parameter));
        $parsedResponse = json_decode($apiResponse, true);

        return $parsedResponse;
    }

    public function processApiResponse(array $apiResponse, string $modelClassName): void
    {

        $longitude = $apiResponse['longitude'];
        $latitude = $apiResponse['latitude'];

        foreach ($apiResponse['hourly']['time'] as $key => $dateTimeOfMeasurement) {
            $parameter = $apiResponse['hourly'][$apiResponse['parameter']][$key];

            $modelClassName::updateOrCreate(
                [
                    'longitude' => $longitude,
                    'latitude' => $latitude,
                    'date_time_of_measurement' => $dateTimeOfMeasurement,
                ],
                [
                    $apiResponse['parameter'] => $parameter,
                ]
            );
        }
    }
    public function process(string $modelClassName): void
    {
        $modelClassName->processing_began_at = Carbon::now();
        $modelClassName->save();

        $apiResponse = $this->getParametersFromApi(
            $modelClassName->city,
            $modelClassName->year,
            $modelClassName->month,
            $modelClassName->parameter);
        $this->processApiResponse($apiResponse);

        $modelClassName->processing_finished_at = Carbon::now();
        $modelClassName->save();
    }
}
