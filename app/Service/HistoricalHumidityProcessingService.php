<?php

namespace App\Service;

use App\Models\HistoricalHumidityProcessingReportsModel;
use DateInterval;
use DateTime;
use Exception;

class HistoricalHumidityProcessingService
{
    public function saveHumidityProcessToDb(): void
    {
        try {
            $startDate = new DateTime(config('city_date.start_date'));
            $today = new DateTime();
            $cities = config('city_date.city');
            while ($startDate < $today) {
                foreach ($cities as $city) {
                    HistoricalHumidityProcessingReportsModel::firstOrCreate(
                        [
                            'year' => $startDate->format('Y'),
                            'month' => $startDate->format('m'),
                            'city' => $city,
                        ]
                    );
                }
                $startDate = $startDate->add(new DateInterval('P1M'));
            }
        } catch (Exception $e) {
            echo $e;
        }
    }
}
