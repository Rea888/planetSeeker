<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoricalRainProcessingReportsModel extends AbstractProcessingReportsModel
{
    protected $fillable = [
        'year',
        'month',
        'city',
        'processing_began_at',
        'processing_finished_at'
    ];
}
