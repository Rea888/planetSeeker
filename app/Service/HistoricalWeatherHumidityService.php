<?php

namespace App\Service;

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

        $apiResponse = Http::get('https://archive-api.open-meteo.com/v1/archive?latitude=' . $latitude . '&longitude=' . $longitude . '&start_date=' . $startDate . '&end_date=' . $endDate . '&hourly=relativehumidity_2m');
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

    public function process(HistoricalWeatherHumidityModel $historicalWeatherHumidityModel): void
    {
        $historicalWeatherHumidityModel->processing_began_at = Carbon::now();
        $historicalWeatherHumidityModel->save();

        $apiResponse = $this->getHistoricalHumidityFromApi(
            $historicalWeatherHumidityModel->city,
            $historicalWeatherHumidityModel->year,
            $historicalWeatherHumidityModel->month);
        $this->processHistoricalWeatherHumidityApiResponse($apiResponse);

        $historicalWeatherHumidityModel->processing_finished_at = Carbon::now();
        $historicalWeatherHumidityModel->save();
    }
}
