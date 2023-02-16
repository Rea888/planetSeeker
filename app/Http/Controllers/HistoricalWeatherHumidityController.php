<?php

namespace App\Http\Controllers;

use App\Repository\HistoricalWeatherTenYearDatesCreator;
use App\Repository\LongitudeLatitudeRepository;
use App\Service\HistoricalWeatherHumidityService;

class HistoricalWeatherHumidityController extends Controller
{

    private LongitudeLatitudeRepository $longitudeLatitudeRepository;
    private HistoricalWeatherHumidityService $historicalWeatherHumidityService;
    private HistoricalWeatherTenYearDatesCreator $historicalWeatherTenYearDatesCreator;

    public function __construct(LongitudeLatitudeRepository          $longitudeLatitudeRepository,
                                HistoricalWeatherHumidityService     $historicalWeatherHumidityService,
                                HistoricalWeatherTenYearDatesCreator $historicalWeatherTenYearDatesCreator)
    {

        $this->longitudeLatitudeRepository = $longitudeLatitudeRepository;
        $this->historicalWeatherHumidityService = $historicalWeatherHumidityService;
        $this->historicalWeatherTenYearDatesCreator = $historicalWeatherTenYearDatesCreator;
    }

}

