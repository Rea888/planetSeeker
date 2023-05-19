<?php

namespace App\Console\Commands;

use App\Data\DataIdentifier;
use DateInterval;
use DateTime;
use Illuminate\Console\Command;

class AbstractInitializeCommand extends Command
{

    protected $signature = 'abstract:initialize';
    protected function getCitiesAndDates()
    {
        $citiesAndDates = [];

        $startDate = new DateTime(config('city_date.start_date'));
        $today = new DateTime();
        $todayMinusOneMonth = $today->modify('-1 month');
        $cities = config('city_date.city');

        while ($startDate < $todayMinusOneMonth) {
            foreach ($cities as $city) {
                $citiesAndDates[] = new DataIdentifier($city, clone $startDate);
            }
            $startDate = $startDate->add(new DateInterval('P1M'));
        }
        return $citiesAndDates;
    }
}
