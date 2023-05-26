<?php

namespace App\Models;

class HistoricalTemperatureProcessingReportsModel extends AbstractProcessingReportsModel
{
    protected $fillable = [
        'year',
        'month',
        'city',
        'processing_began_at',
        'processing_finished_at'
    ];
}
