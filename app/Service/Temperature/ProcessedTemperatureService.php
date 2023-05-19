<?php

namespace App\Service\Temperature;

use App\ApiClient\Google\GoogleApiClient;
use App\ApiClient\Meteo\MeteoApiClient;
use App\Data\Meteo\Temperature\TemperatureData;
use App\Models\HistoricalTemperatureModel;
use App\Models\HistoricalTemperatureProcessingReportsModel;
use Carbon\Carbon;
use DateTime;
use Exception;

class ProcessedTemperatureService
{

    private GoogleApiClient $googleApiClient;
    private MeteoApiClient $meteoApiClient;


    public function __construct(GoogleApiClient $googleApiClient, MeteoApiClient $meteoApiClient)
    {
        $this->googleApiClient = $googleApiClient;
        $this->meteoApiClient = $meteoApiClient;

    }

    public function saveProcessedTemperatureToDB(TemperatureData $humidityData)
    {
        $latitude = $humidityData->getLatitude();
        $longitude = $humidityData->getLongitude();
        $dates = $humidityData->getDateTimeOfMeasurement();
        $temperatures = $humidityData->getTemperatureMeasurementData();

        for ($i = 0; $i < count($dates); $i++) {
            HistoricalTemperatureModel::updateOrCreate(
                [
                    'latitude' => $latitude,
                    'longitude' => $longitude,
                    'date_time_of_measurement' => $dates[$i],
                ],
                [
                    MeteoApiClient::HOURLY_PARAM_VALUE_TEMPERATURE => $temperatures[$i],
                ]
            );
        }
    }

    public function process(HistoricalTemperatureProcessingReportsModel $historicalTemperaturesProcessingReportsModel, $parameter): void
    {
        $historicalTemperaturesProcessingReportsModel->processing_began_at = Carbon::now();
        $historicalTemperaturesProcessingReportsModel->save();

        $coordinatesData = $this->googleApiClient->getCoordinatesForCity($historicalTemperaturesProcessingReportsModel->city);
        $startDate = new DateTime($historicalTemperaturesProcessingReportsModel->year . '-' . $historicalTemperaturesProcessingReportsModel->month . '-01');
        $startDate = $startDate->format('Y-m-d');
        $endDate = new DateTime(date("Y-m-t", strtotime($startDate)));
        $endDate = $endDate->format('Y-m-d');

        if ($parameter === MeteoApiClient::HOURLY_PARAM_VALUE_TEMPERATURE) {
            $data = $this->meteoApiClient->getTemperatureData($startDate, $endDate, $coordinatesData);
            $this->saveProcessedTemperatureToDB($data);
        } else {
            throw new Exception("Unknown parameter: $parameter");
        }
        $historicalTemperaturesProcessingReportsModel->processing_finished_at = Carbon::now();
        $historicalTemperaturesProcessingReportsModel->save();
    }
}
