<?php

namespace App\Models;

use App\Contracts\Processable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoricalTemperatureProcessingReportsModel extends Model implements Processable
{
    use HasFactory;

    protected $fillable = [
        'year',
        'month',
        'city',
        'processing_began_at',
        'processing_finished_at'
    ];

    public static function getUnprocessedModelsWhereBeganAtIsNull()
    {
        return HistoricalTemperatureProcessingReportsModel::where('processing_began_at', null)->get();
    }

    public static function getUnprocessedModelsWhereFinishedAtIsNull()
    {
        return HistoricalTemperatureProcessingReportsModel::where('processing_finished_at', null)->get();

    }
}
