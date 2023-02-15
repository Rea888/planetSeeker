<?php

namespace App\Repository;

use DateInterval;
use DatePeriod;
use DateTime;

class HistoricalWeatherTenYearDatesCreator
{
    public function startDatesArray(): array
    {
        $start = (new DateTime('2013-01-01'))->modify('first day of this month');
        $end = (new DateTime('2023-01-01'))->modify('first day of next month');
        $interval = DateInterval::createFromDateString('1 month');
        $period = new DatePeriod($start, $interval, $end);
        $data = array();

        foreach ($period as $dt) {
            $data_month = array($dt->format("Y-m-d"));
            $data[] = $data_month;
        }

        return $data;
    }

    public function endDatesArray(): array
    {
        $start = (new DateTime('2013-01-31'))->modify('last day of this month');
        $end = (new DateTime('2023-01-31'))->modify('last day of next month');
        $interval = DateInterval::createFromDateString('last day of 1 month');
        $period = new DatePeriod($start, $interval, $end);
        $data = array();

        foreach ($period as $dt) {
            $data_month = array($dt->format("Y-m-d"));
            $data[] = $data_month;
        }

        return $data;
    }

}
