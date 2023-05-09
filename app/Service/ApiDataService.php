<?php

namespace App\Service;

use App\Repository\LongitudeLatitudeRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

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

    public function processApiResponse(array $apiResponse, string $modelClassName, string $parameter): void
    {

        $longitude = $apiResponse['longitude'];
        $latitude = $apiResponse['latitude'];

        foreach ($apiResponse['hourly']['time'] as $key => $dateTimeOfMeasurement) {
            $apiParameter = $apiResponse['hourly'][$parameter][$key];

            $modelClassName::updateOrCreate(
                [
                    'longitude' => $longitude,
                    'latitude' => $latitude,
                    'date_time_of_measurement' => $dateTimeOfMeasurement,
                ],
                [
                    $parameter => $apiParameter,
                ]
            );
        }
    }
    public function process(Model $unprocessedModel, string $modelClassName, string $parameter): void
    {
        $unprocessedModel->processing_began_at = Carbon::now();
        $unprocessedModel->save();

        $apiResponse = $this->getParametersFromApi(
            $unprocessedModel->city,
            $unprocessedModel->year,
            $unprocessedModel->month,
            $parameter,
        );
        $this->processApiResponse($apiResponse, $modelClassName, $parameter);

        $unprocessedModel->processing_finished_at = Carbon::now();
        $unprocessedModel->save();
    }
}
