<?php

namespace App\Service;

use App\Models\HistoricalHumidityProcessingReportsModel;
use App\Models\HistoricalWeatherHumidityModel;
use App\Repository\LongitudeLatitudeRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class HistoricalWeatherHumidityService
{

    private LongitudeLatitudeRepository $longitudeLatitudeRepository;

    public function __construct(LongitudeLatitudeRepository $longitudeLatitudeRepository)
    {
        $this->longitudeLatitudeRepository = $longitudeLatitudeRepository;
    }

    public function getHistoricalHumidityFromApi($cityName, $year, $month): array
    {
        $latitudeAndLongitude = $this->longitudeLatitudeRepository->getLatitudeAndLongitude($cityName);
        $latitude = $latitudeAndLongitude->getLatitude();
        $longitude = $latitudeAndLongitude->getLongitude();

        $startDate = $year . '-' . $month . '-01';
        $endDate = date("Y-m-t", strtotime($startDate));

        $apiResponse = Http::get(sprintf("https://archive-api.open-meteo.com/v1/archive?latitude=%s&longitude=%s&start_date=%s&end_date=%s&hourly=relativehumidity_2m", $latitude, $longitude, $startDate, $endDate));
        $parsedResponse = json_decode($apiResponse, true);

        return $parsedResponse;
    }

    public function processHistoricalWeatherHumidityApiResponse(array $apiResponse): void
    {

        $longitude = $apiResponse['longitude'];
        $latitude = $apiResponse['latitude'];

        foreach ($apiResponse['hourly']['time'] as $key => $dateTimeOfMeasurement) {
            $humidity = $apiResponse['hourly']['relativehumidity_2m'][$key];

            HistoricalWeatherHumidityModel::updateOrCreate(
                [
                    'longitude' => $longitude,
                    'latitude' => $latitude,
                    'date_time_of_measurement' => $dateTimeOfMeasurement,
                ],
                [
                    'relative_humidity_2m' => $humidity,
                ]
            );
        }
    }
    public function process(HistoricalHumidityProcessingReportsModel $historicalHumidityProcessingReportsModel): void
    {
        $historicalHumidityProcessingReportsModel->processing_began_at = Carbon::now();
        $historicalHumidityProcessingReportsModel->save();

        $apiResponse = $this->getHistoricalHumidityFromApi(
            $historicalHumidityProcessingReportsModel->city,
            $historicalHumidityProcessingReportsModel->year,
            $historicalHumidityProcessingReportsModel->month);
        $this->processHistoricalWeatherHumidityApiResponse($apiResponse);

        $historicalHumidityProcessingReportsModel->processing_finished_at = Carbon::now();
        $historicalHumidityProcessingReportsModel->save();
    }
}
