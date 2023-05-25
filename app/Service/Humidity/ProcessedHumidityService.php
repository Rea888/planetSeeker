<?php

namespace App\Service\Humidity;

use App\ApiClient\Google\GoogleApiClient;
use App\ApiClient\Meteo\MeteoApiClient;
use App\Data\Meteo\Humidity\HumidityData;
use App\Models\HistoricalHumidityModel;
use App\Models\HistoricalHumidityProcessingReportsModel;
use Carbon\Carbon;
use DateTime;

class ProcessedHumidityService
{
    private GoogleApiClient $googleApiClient;
    private MeteoApiClient $meteoApiClient;


    public function __construct(GoogleApiClient $googleApiClient, MeteoApiClient $meteoApiClient)
    {
        $this->googleApiClient = $googleApiClient;
        $this->meteoApiClient = $meteoApiClient;

    }

    public function saveProcessedHumidityToDB(HumidityData $humidityData): void
    {
        $latitude = $humidityData->getLatitude();
        $longitude = $humidityData->getLongitude();
        $dates = $humidityData->getDateTimeOfMeasurement();
        $humidities = $humidityData->getHumidityMeasurementData();

        foreach ($dates as $key => $date) {
            $humidity = $humidities[$key];
            HistoricalHumidityModel::updateOrCreate(
                [
                    'latitude' => $latitude,
                    'longitude' => $longitude,
                    'date_time_of_measurement' => $date,
                ],
                [
                    MeteoApiClient::HOURLY_PARAM_VALUE_HUMIDITY => $humidity,
                ]
            );
        }
    }

    public function process(HistoricalHumidityProcessingReportsModel $historicalHumidityProcessingReportsModel): void
    {
        $historicalHumidityProcessingReportsModel->processing_began_at = Carbon::now();
        $historicalHumidityProcessingReportsModel->save();

        $coordinatesData = $this->googleApiClient->getCoordinatesForCity($historicalHumidityProcessingReportsModel->city);
        $startDate = new DateTime($historicalHumidityProcessingReportsModel->year . '-' . $historicalHumidityProcessingReportsModel->month . '-01');
        $startDate = $startDate->format('Y-m-d');
        $endDate = new DateTime(date("Y-m-t", strtotime($startDate)));
        $endDate = $endDate->format('Y-m-d');

        $data = $this->meteoApiClient->getHumidityData($startDate, $endDate, $coordinatesData);
        $this->saveProcessedHumidityToDB($data);

        $historicalHumidityProcessingReportsModel->processing_finished_at = Carbon::now();
        $historicalHumidityProcessingReportsModel->save();
    }
}
