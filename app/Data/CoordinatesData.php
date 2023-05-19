<?php

namespace App\Data;

class CoordinatesData
{

    public function __construct(
        private readonly float $longitude,
        private readonly float $latitude,
    )
    {
    }

    public function getLongitude(): float
    {
        return $this->longitude;
    }

    public function getLatitude(): float
    {
        return $this->latitude;
    }
}
