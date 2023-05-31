<?php

namespace App\Service\Surface_Pressure;

use App\ApiClient\Google\GoogleApiClient;
use App\ApiClient\Meteo\MeteoApiClient;
use App\Data\Meteo\Surface_Pressure\SurfacePressureData;
use App\Models\HistoricalSurfacePressureModel;
use App\Models\HistoricalSurfacePressureProcessingReportsModel;
use DateTime;
use Exception;
use Illuminate\Http\Client\RequestException;

class ProcessedSurfacePressureService
{
    private GoogleApiClient $googleApiClient;
    private MeteoApiClient $meteoApiClient;


    public function __construct(GoogleApiClient $googleApiClient, MeteoApiClient $meteoApiClient)
    {
        $this->googleApiClient = $googleApiClient;
        $this->meteoApiClient = $meteoApiClient;

    }

    public function saveProcessedSurfacePressureToDB(SurfacePressureData $surfacePressureData): void
    {
        $latitude = $surfacePressureData->getLatitude();
        $longitude = $surfacePressureData->getLongitude();
        $dates = $surfacePressureData->getDateTimeOfMeasurement();
        $surfacePressures = $surfacePressureData->getSurfacePressureMeasurementData();

        foreach ($dates as $key => $date) {
            $surfacePressure = $surfacePressures[$key];
            HistoricalSurfacePressureModel::updateOrCreate(
                [
                    'latitude' => $latitude,
                    'longitude' => $longitude,
                    'date_time_of_measurement' => $date,
                ],
                [
                    MeteoApiClient::HOURLY_PARAM_VALUE_SURFACE_PRESSURE => $surfacePressure,
                ]
            );
        }
    }

    /**
     * @throws RequestException
     * @throws Exception
     */
    public function process(HistoricalSurfacePressureProcessingReportsModel $historicalSurfacePressureProcessingRepostsModelProcessingReportsModel): void
    {
        $historicalSurfacePressureProcessingRepostsModelProcessingReportsModel->startProcessing();

        $coordinatesData = $this->googleApiClient->getCoordinatesForCity($historicalSurfacePressureProcessingRepostsModelProcessingReportsModel->city);
        $startDate = new DateTime($historicalSurfacePressureProcessingRepostsModelProcessingReportsModel->year . '-' . $historicalSurfacePressureProcessingRepostsModelProcessingReportsModel->month . '-01');
        $startDate = $startDate->format('Y-m-d');
        $endDate = new DateTime(date("Y-m-t", strtotime($startDate)));
        $endDate = $endDate->format('Y-m-d');

        $data = $this->meteoApiClient->getSurfacePressureData($startDate, $endDate, $coordinatesData);
        $this->saveProcessedSurfacePressureToDB($data);

        $historicalSurfacePressureProcessingRepostsModelProcessingReportsModel->finishProcessing();
    }
}
