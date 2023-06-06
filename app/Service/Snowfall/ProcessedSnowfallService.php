<?php

namespace App\Service\Snowfall;

use App\ApiClient\Google\GoogleApiClient;
use App\ApiClient\Meteo\MeteoApiClient;
use App\Data\Meteo\Snowfall\SnowfallData;
use App\Models\HistoricalSnowfallModel;
use App\Models\HistoricalSnowfallProcessingReportsModel;
use DateTime;
use Exception;
use Illuminate\Http\Client\RequestException;

class ProcessedSnowfallService
{
    private GoogleApiClient $googleApiClient;
    private MeteoApiClient $meteoApiClient;


    public function __construct(GoogleApiClient $googleApiClient, MeteoApiClient $meteoApiClient)
    {
        $this->googleApiClient = $googleApiClient;
        $this->meteoApiClient = $meteoApiClient;

    }

    public function saveProcessedSnowfallToDB(SnowfallData $snowfallData): void
    {
        $latitude = $snowfallData->getLatitude();
        $longitude = $snowfallData->getLongitude();
        $dates = $snowfallData->getDateTimeOfMeasurement();
        $snowfalls = $snowfallData->getSnowfallMeasurementData();

        foreach ($dates as $key => $date) {
            $snowfall = $snowfalls[$key];
            HistoricalSnowfallModel::updateOrCreate(
                [
                    'latitude' => $latitude,
                    'longitude' => $longitude,
                    'date_time_of_measurement' => $date,
                ],
                [
                    MeteoApiClient::HOURLY_PARAM_VALUE_SNOWFALL => $snowfall,
                ]
            );
        }
    }

    /**
     * @throws RequestException
     * @throws Exception
     */
    public function process(HistoricalSnowfallProcessingReportsModel $historicalSnowfallProcessingReportsModel): void
    {
        $historicalSnowfallProcessingReportsModel->startProcessing();

        $coordinatesData = $this->googleApiClient->getCoordinatesForCity($historicalSnowfallProcessingReportsModel->city);
        $startDate = new DateTime($historicalSnowfallProcessingReportsModel->year . '-' . $historicalSnowfallProcessingReportsModel->month . '-01');
        $startDate = $startDate->format('Y-m-d');
        $endDate = new DateTime(date("Y-m-t", strtotime($startDate)));
        $endDate = $endDate->format('Y-m-d');

        $data = $this->meteoApiClient->getSnowfallData($startDate, $endDate, $coordinatesData);
        $this->saveProcessedSnowfallToDB($data);

        $historicalSnowfallProcessingReportsModel->finishProcessing();
    }
}
