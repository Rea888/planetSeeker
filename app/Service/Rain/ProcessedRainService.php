<?php

namespace App\Service\Rain;

use App\ApiClient\Google\GoogleApiClient;
use App\ApiClient\Meteo\MeteoApiClient;
use App\Data\Meteo\Rain\RainData;
use App\Models\HistoricalRainModel;
use App\Models\HistoricalRainProcessingReportsModel;
use DateTime;
use Exception;
use Illuminate\Http\Client\RequestException;

class ProcessedRainService
{
    private GoogleApiClient $googleApiClient;
    private MeteoApiClient $meteoApiClient;


    public function __construct(GoogleApiClient $googleApiClient, MeteoApiClient $meteoApiClient)
    {
        $this->googleApiClient = $googleApiClient;
        $this->meteoApiClient = $meteoApiClient;

    }

    public function saveProcessedRainToDB(RainData $rainData): void
    {
        $latitude = $rainData->getLatitude();
        $longitude = $rainData->getLongitude();
        $dates = $rainData->getDateTimeOfMeasurement();
        $rains = $rainData->getRainMeasurementData();

        foreach ($dates as $key => $date) {
            $rain = $rains[$key];
            HistoricalRainModel::updateOrCreate(
                [
                    'latitude' => $latitude,
                    'longitude' => $longitude,
                    'date_time_of_measurement' => $date,
                ],
                [
                    MeteoApiClient::HOURLY_PARAM_VALUE_RAIN => $rain,
                ]
            );
        }
    }

    /**
     * @throws RequestException
     * @throws Exception
     */
    public function process(HistoricalRainProcessingReportsModel $historicalRainProcessingReportsModel): void
    {
        $historicalRainProcessingReportsModel->startProcessing();

        $coordinatesData = $this->googleApiClient->getCoordinatesForCity($historicalRainProcessingReportsModel->city);
        $startDate = new DateTime($historicalRainProcessingReportsModel->year . '-' . $historicalRainProcessingReportsModel->month . '-01');
        $startDate = $startDate->format('Y-m-d');
        $endDate = new DateTime(date("Y-m-t", strtotime($startDate)));
        $endDate = $endDate->format('Y-m-d');

        $data = $this->meteoApiClient->getRainData($startDate, $endDate, $coordinatesData);
        $this->saveProcessedRainToDB($data);

        $historicalRainProcessingReportsModel->finishProcessing();
    }
}
