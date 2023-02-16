<?php

namespace App\Repository;

use DateInterval;
use DatePeriod;
use DateTime;

class HistoricalWeatherTenYearDatesCreator
{
    public function getStartDatesArray(): array
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

    public function getEndDatesArray(): array
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

    public function getCityYearMonthArray(): array
    {
        $cityYearMonthArray = array(

            'city' => ['Paris', 'Moscow', 'Washington', 'London', 'Tokyo',],
            'year' => ['2013', '2014', '2015', '2016', '2017', '2018', '2019', '2020', '2021', '2022', '2023',],
            'month' => ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12',],
        );
        return $cityYearMonthArray;
    }
}
