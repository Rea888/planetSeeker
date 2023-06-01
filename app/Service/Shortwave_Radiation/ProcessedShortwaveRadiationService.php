<?php

namespace App\Service\Shortwave_Radiation;

use App\ApiClient\Google\GoogleApiClient;
use App\ApiClient\Meteo\MeteoApiClient;
use App\Data\Meteo\Shortwave_Radiation\ShortwaveRadiationData;
use App\Models\HistoricalShortwaveRadiationModel;
use App\Models\HistoricalShortwaveRadiationProcessingReportsModel;
use DateTime;
use Exception;
use Illuminate\Http\Client\RequestException;

class ProcessedShortwaveRadiationService
{
    private GoogleApiClient $googleApiClient;
    private MeteoApiClient $meteoApiClient;


    public function __construct(GoogleApiClient $googleApiClient, MeteoApiClient $meteoApiClient)
    {
        $this->googleApiClient = $googleApiClient;
        $this->meteoApiClient = $meteoApiClient;

    }

    public function saveProcessedShortwaveRadiationToDB(ShortwaveRadiationData $shortwaveRadiationData): void
    {
        $latitude = $shortwaveRadiationData->getLatitude();
        $longitude = $shortwaveRadiationData->getLongitude();
        $dates = $shortwaveRadiationData->getDateTimeOfMeasurement();
        $shortWaveRadiations = $shortwaveRadiationData->getShortwaveRadiationMeasurementData();

        foreach ($dates as $key => $date) {
            $shortWaveRadiation = $shortWaveRadiations[$key];
            HistoricalShortwaveRadiationModel::updateOrCreate(
                [
                    'latitude' => $latitude,
                    'longitude' => $longitude,
                    'date_time_of_measurement' => $date,
                ],
                [
                    MeteoApiClient::HOURLY_PARAM_VALUE_SHORTWAVE_RADIATION => $shortWaveRadiation,
                ]
            );
        }
    }

    /**
     * @throws RequestException
     * @throws Exception
     */
    public function process(HistoricalShortwaveRadiationProcessingReportsModel $historicalShortwaveRadiationProcessingReportsModel): void
    {
        $historicalShortwaveRadiationProcessingReportsModel->startProcessing();

        $coordinatesData = $this->googleApiClient->getCoordinatesForCity($historicalShortwaveRadiationProcessingReportsModel->city);
        $startDate = new DateTime($historicalShortwaveRadiationProcessingReportsModel->year . '-' . $historicalShortwaveRadiationProcessingReportsModel->month . '-01');
        $startDate = $startDate->format('Y-m-d');
        $endDate = new DateTime(date("Y-m-t", strtotime($startDate)));
        $endDate = $endDate->format('Y-m-d');

        $data = $this->meteoApiClient->getShortwaveRadiationData($startDate, $endDate, $coordinatesData);
        $this->saveProcessedShortwaveRadiationToDB($data);

        $historicalShortwaveRadiationProcessingReportsModel->finishProcessing();
    }
}
