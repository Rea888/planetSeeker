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
                    //TODO: add message to start processing this record
                }
                $startDate = $startDate->add(new DateInterval('P1M'));
            }
        } catch (Exception $e) {
            echo $e;
        }
    }

    public function getUnprocessedHumidityModelsBeganAt()
    {
        return HistoricalHumidityProcessingReportsModel::where('processing_began_at', null)->get();

    }

    public function getUnprocessedHumidityModelsFinishedAt()
    {

            return HistoricalHumidityProcessingReportsModel::whereNull('processing_finished_at')->whereNotNull('processing_began_at')->get();

    }
}

