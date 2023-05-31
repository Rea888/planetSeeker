<?php

namespace App\Service\Temperature;

use App\ApiClient\Google\GoogleApiClient;
use App\ApiClient\Meteo\MeteoApiClient;
use App\Data\Meteo\Temperature\TemperatureData;
use App\Models\HistoricalTemperatureModel;
use App\Models\HistoricalTemperatureProcessingReportsModel;
use DateTime;
use Exception;
use Illuminate\Http\Client\RequestException;

class ProcessedTemperatureService
{

    private GoogleApiClient $googleApiClient;
    private MeteoApiClient $meteoApiClient;


    public function __construct(GoogleApiClient $googleApiClient, MeteoApiClient $meteoApiClient)
    {
        $this->googleApiClient = $googleApiClient;
        $this->meteoApiClient = $meteoApiClient;

    }

    public function saveProcessedTemperatureToDB(TemperatureData $temperatureData): void
    {
        $latitude = $temperatureData->getLatitude();
        $longitude = $temperatureData->getLongitude();
        $dates = $temperatureData->getDateTimeOfMeasurement();
        $temperatures = $temperatureData->getTemperatureMeasurementData();

        foreach ($dates as $key => $date) {
            $temperature = $temperatures[$key];
            HistoricalTemperatureModel::updateOrCreate(
                [
                    'latitude' => $latitude,
                    'longitude' => $longitude,
                    'date_time_of_measurement' => $date,
                ],
                [
                    MeteoApiClient::HOURLY_PARAM_VALUE_TEMPERATURE => $temperature,
                ]
            );
        }
    }

    /**
     * @throws RequestException
     * @throws Exception
     */
    public function process(HistoricalTemperatureProcessingReportsModel $historicalTemperaturesProcessingReportsModel): void
    {
        $historicalTemperaturesProcessingReportsModel->startProcessing();

        $coordinatesData = $this->googleApiClient->getCoordinatesForCity($historicalTemperaturesProcessingReportsModel->city);
        $startDate = new DateTime($historicalTemperaturesProcessingReportsModel->year . '-' . $historicalTemperaturesProcessingReportsModel->month . '-01');
        $startDate = $startDate->format('Y-m-d');
        $endDate = new DateTime(date("Y-m-t", strtotime($startDate)));
        $endDate = $endDate->format('Y-m-d');

        $data = $this->meteoApiClient->getTemperatureData($startDate, $endDate, $coordinatesData);
        $this->saveProcessedTemperatureToDB($data);

        $historicalTemperaturesProcessingReportsModel->finishProcessing();
    }
}
