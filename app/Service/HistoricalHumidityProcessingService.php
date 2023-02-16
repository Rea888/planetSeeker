<?php

namespace App\Service;

use App\Models\HistoricalHumidityProcessingReportsModel;

class HistoricalHumidityProcessingService
{

    public function saveHumidityProcessToDb(): void
    {
        foreach (config('city_date.city_date')['year'] as $year) {
            foreach (config('city_date.city_date')['month'] as $month) {
                foreach (config('city_date.city_date')['city'] as $city) {
                    if (intval($year) == 2023 && intval($month) >= 02) {
                        exit();
                    } else {

                        HistoricalHumidityProcessingReportsModel::firstOrCreate(
                            [
                                'year' => intval($year),
                                'month' => intval($month),
                                'city' => $city,
                            ]
                        );
                    }
                }
            }
        }
    }
}
