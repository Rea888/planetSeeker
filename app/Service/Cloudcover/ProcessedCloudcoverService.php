<?php

namespace App\Service\Cloudcover;

use App\ApiClient\Google\GoogleApiClient;
use App\ApiClient\Meteo\MeteoApiClient;
use App\Data\Meteo\Cloudcover\CloudcoverData;
use App\Models\HistoricalCloudcoverModel;
use App\Models\HistoricalCloudcoverProcessingReportsModel;
use DateTime;
use Exception;
use Illuminate\Http\Client\RequestException;

class ProcessedCloudcoverService
{
    private GoogleApiClient $googleApiClient;
    private MeteoApiClient $meteoApiClient;


    public function __construct(GoogleApiClient $googleApiClient, MeteoApiClient $meteoApiClient)
    {
        $this->googleApiClient = $googleApiClient;
        $this->meteoApiClient = $meteoApiClient;

    }

    public function saveProcessedCloudcoverToDB(CloudcoverData $cloudcoverData): void
    {
        $latitude = $cloudcoverData->getLatitude();
        $longitude = $cloudcoverData->getLongitude();
        $dates = $cloudcoverData->getDateTimeOfMeasurement();
        $cloudcovers = $cloudcoverData->getCloudcoverMeasurementData();

        foreach ($dates as $key => $date) {
            $cloudcover = $cloudcovers[$key];
            HistoricalCloudcoverModel::updateOrCreate(
                [
                    'latitude' => $latitude,
                    'longitude' => $longitude,
                    'date_time_of_measurement' => $date,
                ],
                [
                    MeteoApiClient::HOURLY_PARAM_VALUE_CLOUDCOVER => $cloudcover,
                ]
            );
        }
    }

    /**
     * @throws RequestException
     * @throws Exception
     */
    public function process(HistoricalCloudcoverProcessingReportsModel $historicalCloudcoverProcessingReportsModel): void
    {
        $historicalCloudcoverProcessingReportsModel->startProcessing();

        $coordinatesData = $this->googleApiClient->getCoordinatesForCity($historicalCloudcoverProcessingReportsModel->city);
        $startDate = new DateTime($historicalCloudcoverProcessingReportsModel->year . '-' . $historicalCloudcoverProcessingReportsModel->month . '-01');
        $startDate = $startDate->format('Y-m-d');
        $endDate = new DateTime(date("Y-m-t", strtotime($startDate)));
        $endDate = $endDate->format('Y-m-d');

        $data = $this->meteoApiClient->getCloudcoverData($startDate, $endDate, $coordinatesData);
        $this->saveProcessedCloudcoverToDB($data);

        $historicalCloudcoverProcessingReportsModel->finishProcessing();
    }
}
