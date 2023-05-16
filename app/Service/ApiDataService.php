<?php

namespace App\Service;

use App\Contracts\Processable;
use Carbon\Carbon;

class ApiDataService
{


    private ApiWeatherClient $apiWeatherClient;
    private ModelFromParameter $modelFromParameter;

    public function __construct(ApiWeatherClient $apiWeatherClient, ModelFromParameter $modelFromParameter)
    {

        $this->apiWeatherClient = $apiWeatherClient;
        $this->modelFromParameter = $modelFromParameter;
    }

    public function processApiResponse( $apiResponse, string $parameter): void
    {

        $longitude = $apiResponse->getLongitude();
        $latitude = $apiResponse->getLatitude();

        foreach ($apiResponse->getDateTimeOfMeasurement() as $key => $dateTimeOfMeasurement) {
            $apiParameter = $apiResponse->getParameter($parameter)[$key];
            $modelClassName =$this->modelFromParameter->getProcessedModelByParameter($parameter);
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
    public function process(Processable $processableModel, $parameter): void
    {
        $unprocessedModel = $processableModel;
        $unprocessedModel->processing_began_at = Carbon::now();
        $unprocessedModel->save();

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
