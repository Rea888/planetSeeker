<?php

namespace App\Console\Commands;

use App\Data\DataIdentifier;
use DateInterval;

use DateTimeImmutable;
use Illuminate\Console\Command;

abstract class AbstractInitializeCommand extends Command
{
    protected function getCitiesAndDates(): array
    {
        $citiesAndDates = [];
        $dateDelayOneMonth = new DateInterval('P1M');

        $startDate = new DateTimeImmutable(config('city_date.start_date'));
        $today = new DateTimeImmutable();
        $todayMinusOneMonth = $today->modify('-1 month');
        $cities = config('city_date.city');

        while ($startDate < $todayMinusOneMonth) {
            foreach ($cities as $city) {
                $citiesAndDates[] = new DataIdentifier($city, $startDate);
            }
            $startDate = $startDate->add($dateDelayOneMonth);
        }
        return $citiesAndDates;
    }
}
