<?php

namespace App\ApiClient\Meteo;

use App\Data\CoordinatesData;
use App\Data\Meteo\Cloudcover\CloudcoverData;
use App\Data\Meteo\Humidity\HumidityData;
use App\Data\Meteo\Surface_Pressure\SurfacePressureData;
use App\Data\Meteo\Temperature\TemperatureData;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;

class MeteoApiClient
{
    public const HOURLY_PARAM_VALUE_TEMPERATURE = 'temperature_2m';
    public const HOURLY_PARAM_VALUE_HUMIDITY = 'relativehumidity_2m';
    public const HOURLY_PARAM_VALUE_SURFACE_PRESSURE = 'surface_pressure';
    public const HOURLY_PARAM_VALUE_CLOUDCOVER = 'cloudcover';

    private TemperatureDataMapper $temperatureDataMapper;
    private HumidityDataMapper $humidityDataMapper;
    private SurfacePressureDataMapper $surfacePressureDataMapper;
    private CloudcoverDataMapper $cloudcoverDataMapper;
    private string $baseUrl;

    public function __construct(
        TemperatureDataMapper $temperatureDataMapper,
        HumidityDataMapper    $humidityDataMapper,
        SurfacePressureDataMapper $surfacePressureDataMapper,
        CloudcoverDataMapper  $cloudcoverDataMapper,
        string                $baseUrl
    )
    {
        $this->baseUrl = $baseUrl;
        $this->temperatureDataMapper = $temperatureDataMapper;
        $this->humidityDataMapper = $humidityDataMapper;
        $this->surfacePressureDataMapper = $surfacePressureDataMapper;
        $this->cloudcoverDataMapper = $cloudcoverDataMapper;
    }

    /**
     * @throws RequestException
     */
    public function getTemperatureData(
        string        $startDate,
        string        $endDate,
        CoordinatesData $coordinatesData
    ): TemperatureData
    {
        $preparedQueryParams = $this->prepareQueryParams($startDate, $endDate, $coordinatesData);
        $preparedQueryParams['hourly'] = self::HOURLY_PARAM_VALUE_TEMPERATURE;

        $apiResponse = Http::get($this->getFormattedBaseUrl(), $preparedQueryParams);
        $apiResponse->throw();

        return $this->temperatureDataMapper->map($apiResponse);
    }

    /**
     * @throws RequestException
     */
    public function getHumidityData(
        string       $startDate,
        string       $endDate,
        CoordinatesData $coordinatesData
    ): HumidityData
    {
        $preparedQueryParams = $this->prepareQueryParams($startDate, $endDate, $coordinatesData);
        $preparedQueryParams['hourly'] = self::HOURLY_PARAM_VALUE_HUMIDITY;

        $apiResponse = Http::get($this->getFormattedBaseUrl(), $preparedQueryParams);
        $apiResponse->throw();

        return $this->humidityDataMapper->map($apiResponse);
    }

    /**
     * @throws RequestException
     */
    public function getSurfacePressureData(
        string      $startDate,
        string      $endDate,
        CoordinatesData $coordinatesData
    ): SurfacePressureData
    {
        $preparedQueryParams = $this->prepareQueryParams($startDate, $endDate, $coordinatesData);
        $preparedQueryParams['hourly'] = self::HOURLY_PARAM_VALUE_SURFACE_PRESSURE;

        $apiResponse = Http::get($this->getFormattedBaseUrl(), $preparedQueryParams);
        $apiResponse->throw();

        return $this->surfacePressureDataMapper->map($apiResponse);
    }

    /**
     * @throws RequestException
     */
    public function getCloudcoverData(
        string      $startDate,
        string      $endDate,
        CoordinatesData $coordinatesData
    ): CloudcoverData
    {
        $preparedQueryParams = $this->prepareQueryParams($startDate, $endDate, $coordinatesData);
        $preparedQueryParams['hourly'] = self::HOURLY_PARAM_VALUE_CLOUDCOVER;

        $apiResponse = Http::get($this->getFormattedBaseUrl(), $preparedQueryParams);
        $apiResponse->throw();

        return $this->cloudcoverDataMapper->map($apiResponse);
    }

    private function prepareQueryParams(
        string        $startDate,
        string        $endDate,
        CoordinatesData $coordinatesData
    ): array
    {
        return [
            'latitude' => (string)$coordinatesData->getLatitude(),
            'longitude' => (string)$coordinatesData->getLongitude(),
            'start_date' => $startDate,
            'end_date' => $endDate,
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
