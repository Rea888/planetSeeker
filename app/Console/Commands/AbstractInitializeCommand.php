<?php

namespace App\Console\Commands;

use App\Data\DataIdentifier;
use DateInterval;
use DateTime;
use Exception;
use Illuminate\Console\Command;

abstract class AbstractInitializeCommand extends Command
{
    /**
     * @return DataIdentifier[]
     * @throws Exception
     */
    protected function getCitiesAndDates(): array
    {
        $citiesAndDates = [];

        $startDate = new DateTime(config('city_date.start_date'));
        $today = new DateTime();
        $todayMinusOneMonth = $today->modify('-1 month');
        $cities = config('city_date.city');

        while ($startDate < $todayMinusOneMonth) {
            foreach ($cities as $city) {
                $citiesAndDates[] = new DataIdentifier($city, $startDate);
            }
            $startDate = $startDate->add(new DateInterval('P1M'));
        }

        return $citiesAndDates;
    }
}
