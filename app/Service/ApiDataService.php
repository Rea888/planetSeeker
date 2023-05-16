<?php

namespace App\Service;

use App\ApiClient\Google\GoogleApiClient;
use App\ApiClient\Meteo\MeteoApiClient;
use App\Contracts\Processable;
use Carbon\Carbon;
use DateTime;
use Exception;

class ApiDataService
{


    private ApiWeatherClient $apiWeatherClient;
    private ModelFromParameter $modelFromParameter;
    private GoogleApiClient $googleApiClient;
    private MeteoApiClient $meteoApiClient;

    public function __construct(
        ApiWeatherClient   $apiWeatherClient,
        ModelFromParameter $modelFromParameter,
        GoogleApiClient    $googleApiClient,
        MeteoApiClient     $meteoApiClient,
    )
    {

        $this->apiWeatherClient = $apiWeatherClient;
        $this->modelFromParameter = $modelFromParameter;
        $this->googleApiClient = $googleApiClient;
        $this->meteoApiClient = $meteoApiClient;
    }

    public function processApiResponse($apiResponse, string $parameter): void
    {

        $longitude = $apiResponse->getLongitude();
        $latitude = $apiResponse->getLatitude();

        foreach ($apiResponse->getDateTimeOfMeasurement() as $key => $dateTimeOfMeasurement) {
            $apiParameter = $apiResponse->getParameter($parameter)[$key];
            $modelClassName = $this->modelFromParameter->getProcessedModelByParameter($parameter);
            $modelClassName::updateOrCreate(
                [
                    'longitude' => $longitude,
                    'latitude' => $latitude,
                    'date_time_of_measurement' => $dateTimeOfMeasurement,
                ],
                [
                    $parameter => $apiParameter,
                ]
            );
        }
    }

    /**
     * @throws Exception
     */
    public function process(Processable $processableModel, $parameter): void
    {
        $unprocessedModel = $processableModel;
        $unprocessedModel->processing_began_at = Carbon::now();
        $unprocessedModel->save();

        $coordinatesData = $this->googleApiClient->getCoordinatesForCity($unprocessedModel->city);
        $startDate = new DateTime($unprocessedModel->year . '-' . $unprocessedModel->month . '-01');
        $endDate = new DateTime(date("Y-m-t", strtotime($startDate)));


        //TODO: refactor to different classes, this IF shouldn't exist ^^
        if ($parameter === MeteoApiClient::HOURLY_PARAM_VALUE_HUMIDITY) {
            $humidityData = $this->meteoApiClient->getHumidityData($startDate, $endDate, $coordinatesData);
        } elseif ($parameter === MeteoApiClient::HOURLY_PARAM_VALUE_TEMPERATURE) {
            $temperatureData = $this->meteoApiClient->getTemperatureData($startDate, $endDate, $coordinatesData);
        }

        $apiResponse = $this->apiWeatherClient->getParametersFromWeatherApi(
            $unprocessedModel->city,
            $unprocessedModel->year,
            $unprocessedModel->month,
            $parameter
        );
        $this->processApiResponse($apiResponse, $parameter);

        $unprocessedModel->processing_finished_at = Carbon::now();
        $unprocessedModel->save();
    }
}
