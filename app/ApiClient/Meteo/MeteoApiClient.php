<?php

namespace App\ApiClient\Meteo;

use App\Data\CoordinatesData;
use App\Data\Meteo\HumidityData;
use App\Data\Meteo\TemperatureData;
use DateTime;
use Illuminate\Support\Facades\Http;

class MeteoApiClient
{
    public const HOURLY_PARAM_VALUE_TEMPERATURE = 'temperature_2m';
    public const HOURLY_PARAM_VALUE_HUMIDITY = 'relativehumidity_2m';
    private TemperatureDataMapper $temperatureDataMapper;
    private HumidityDataMapper $humidityDataMapper;

    private string $baseUrl;

    public function __construct(
        TemperatureDataMapper $temperatureDataMapper,
        HumidityDataMapper    $humidityDataMapper,
        string                $baseUrl
    )
    {
        $this->baseUrl = $baseUrl;
        $this->temperatureDataMapper = $temperatureDataMapper;
        $this->humidityDataMapper = $humidityDataMapper;
    }

    public function getTemperatureData(
        DateTime        $startDate,
        DateTime        $endDate,
        CoordinatesData $coordinatesData
    ): TemperatureData
    {
        $preparedQueryParams = $this->prepareQueryParams($startDate, $endDate, $coordinatesData);
        $preparedQueryParams['hourly'] = self::HOURLY_PARAM_VALUE_TEMPERATURE;

        $apiResponse = Http::get($this->baseUrl, $preparedQueryParams);
        $apiResponse->throw();

        return $this->temperatureDataMapper->map($apiResponse);
    }

    public function getHumidityData(
        DateTime        $startDate,
        DateTime        $endDate,
        CoordinatesData $coordinatesData
    ): HumidityData
    {
        $preparedQueryParams = $this->prepareQueryParams($startDate, $endDate, $coordinatesData);
        $preparedQueryParams['hourly'] = self::HOURLY_PARAM_VALUE_HUMIDITY;

        $apiResponse = Http::get($this->baseUrl, $preparedQueryParams);
        $apiResponse->throw();

        return $this->humidityDataMapper->map($apiResponse);

    }

    private function prepareQueryParams(
        DateTime        $startDate,
        DateTime        $endDate,
        CoordinatesData $coordinatesData
    ): array
    {
        return [
            'latitude' => (string)$coordinatesData->getLatitude(),
            'longitude' => (string)$coordinatesData->getLongitude(),
            'startDate' => $startDate->format('Y-m-d'),
            'endDate' => $endDate->format('Y-m-d'),
        ];
    }

    private function getFormattedBaseUrl(): string
    {
        if (str_ends_with($this->baseUrl, '?')) {
            return $this->baseUrl;
        }

        return $this->baseUrl . '?';
    }
}
