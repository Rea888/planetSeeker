<?php

namespace App\Service;

class WeatherApiResponseWrapper
{
    private array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function getLatitude()
    {

        return $this->data['latitude'] ?? null;
    }

    public function getLongitude()
    {

        return $this->data['longitude'] ?? null;
    }

    public function getDateTimeOfMeasurement()
    {
        return $this->data['hourly']['time'] ?? null;
    }

    public function getParameter(string $parameter)
    {
        return $this->data['hourly'][$parameter] ?? null;
    }


}

