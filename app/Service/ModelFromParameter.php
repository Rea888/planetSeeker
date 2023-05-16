<?php

namespace App\Service;

class ModelFromParameter
{

    public function getUnprocessedModelByParameter(string $parameter): \App\Contracts\Processable
    {
        switch ($parameter) {
            case 'temperature_2m':
                return  new \App\Models\HistoricalTemperatureProcessingReportsModel();
            case 'relativehumidity_2m':
                return new \App\Models\HistoricalHumidityProcessingReportsModel();
            default:
                throw new \InvalidArgumentException("Invalid parameter: $parameter");
        }
    }

    public function getProcessedModelByParameter(string $parameter)
    {
        switch ($parameter) {
            case 'temperature_2m':
                return new \App\Models\HistoricalTemperatureModel();
            case 'relativehumidity_2m':
                return new \App\Models\HistoricalWeatherHumidityModel();
            default:
                throw new \InvalidArgumentException("Invalid parameter: $parameter");
        }
    }
}
