<?php

namespace App\Service\Windspeed;

use App\ApiClient\Google\GoogleApiClient;
use App\ApiClient\Meteo\MeteoApiClient;
use App\Data\Meteo\Windspeed\WindspeedData;
use App\Models\HistoricalWindspeedModel;
use App\Models\HistoricalWindspeedModelProcessingReportsModel;
use DateTime;
use Exception;

class ProcessedWindspeedService
{
    private GoogleApiClient $googleApiClient;
    private MeteoApiClient $meteoApiClient;

    public function __construct(GoogleApiClient $googleApiClient, MeteoApiClient $meteoApiClient)
    {

        $this->googleApiClient = $googleApiClient;
        $this->meteoApiClient = $meteoApiClient;
    }

    public function saveProcessedWindspeed(WindspeedData $windspeedData): void
    {
        $latitude = $windspeedData->getLatitude();
        $longitude = $windspeedData->getLongitude();
        $dates = $windspeedData->getDateTimeOfMeasurement();
        $windspeeds = $windspeedData->getWindspeedMeasurementData();

        foreach ($dates as $key => $date) {
            $windspeed = $windspeeds[$key];
            HistoricalWindspeedModel::updateOrCreate(
                [
                    'latitude' => $latitude,
                    'longitude' => $longitude,
                    'date_time_of_measurement' => $date,
                ],
                [
                    MeteoApiClient::HOURLY_PARAM_VALUE_WINDSPEED => $windspeed
                ]
            );
        }
    }

    /**
     * @throws Exception
     */
    public function process(HistoricalWindspeedModelProcessingReportsModel $historicalWindspeedModelProcessingReportsModel): void
    {
        $historicalWindspeedModelProcessingReportsModel->startProcessing();

        $coordinatesData = $this->googleApiClient->getCoordinatesForCity($historicalWindspeedModelProcessingReportsModel->city);
        $startDate = new DateTime($historicalWindspeedModelProcessingReportsModel->year . '-' . $historicalWindspeedModelProcessingReportsModel->month . '-01');
        $startDate = $startDate->format('Y-m-d');
        $endDate = new DateTime(date("Y-m-t", strtotime($startDate)));
        $endDate = $endDate->format('Y-m-d');

        $data = $this->meteoApiClient->getWindspeedData($startDate, $endDate, $coordinatesData);
        $this->saveProcessedWindspeed($data);

        $historicalWindspeedModelProcessingReportsModel->finishProcessing();
    }
}
