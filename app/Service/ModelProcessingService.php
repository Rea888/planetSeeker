<?php

namespace App\Service;

use DateInterval;
use DateTime;
use Exception;


class ModelProcessingService
{
    public function saveModelProcessToDb(string $modelClassName): void
    {
        try {
            $startDate = new DateTime(config('city_date.start_date'));
            $today = new DateTime();
            $todayMinusOneMonth = $today->modify('-1 month');
            $cities = config('city_date.city');
            while ($startDate < $todayMinusOneMonth) {
                foreach ($cities as $city) {
                    $modelClassName::firstOrCreate(
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

